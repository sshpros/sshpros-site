<?php

/**
 * Plugin Name: Big Sky
 * Plugin URI: https://automattic.com/
 * Update URI: https://github.com/Automattic/big-sky-plugin
 * Description: The Big Sky AI Site Builder.
 * Version: 7.4.9
 * Author: Automattic, Inc.
 * Author URI: https://automattic.com/
 * Text Domain: big-sky
 * Domain Path: /languages
 * License: GPL2
 */

require_once __DIR__ . '/lib/wpcom-rest-api-v2-endpoints.php';

if ( file_exists( __DIR__ . '/vendor/wordpress/abilities-api/abilities-api.php' ) ) {
	require_once __DIR__ . '/vendor/wordpress/abilities-api/abilities-api.php';
}

require_once __DIR__ . '/includes/class-big-sky-chrome.php';

if ( ! class_exists( 'Big_Sky' ) ) {

	class Big_Sky {
		public const ENABLE_OPTION_NAME    = 'big_sky_enable';
		public const SUPPORTED_LOCALES     = [
			// Keys are WP.org and WP.com locale slugs.
			// Values are the English name of the language.
			'ar'    => 'Arabic',
			'de'    => 'German',
			'de_DE' => 'German',
			'es'    => 'Spanish (Spain)',
			'es_ES' => 'Spanish (Spain)',
			'fr'    => 'French (France)',
			'fr_FR' => 'French (France)',
			'he'    => 'Hebrew',
			'he_IL' => 'Hebrew',
			'id'    => 'Indonesian',
			'id_ID' => 'Indonesian',
			'it'    => 'Italian',
			'it_IT' => 'Italian',
			'ja'    => 'Japanese',
			'ko'    => 'Korean',
			'ko_KR' => 'Korean',
			'nl'    => 'Dutch',
			'nl_NL' => 'Dutch',
			'pt-br' => 'Portuguese (Brazil)',
			'pt_BR' => 'Portuguese (Brazil)',
			'ru'    => 'Russian',
			'ru_RU' => 'Russian',
			'sv'    => 'Swedish',
			'sv_SE' => 'Swedish',
			'tr'    => 'Turkish',
			'tr_TR' => 'Turkish',
			'zh-cn' => 'Chinese (China)',
			'zh_CN' => 'Chinese (China)',
			'zh-tw' => 'Chinese (Taiwan)',
			'zh_TW' => 'Chinese (Taiwan)',
		];
		public static $enabled             = '1';
		public static $orchestrator_loaded = false;

		public const WP_ADMIN_ORCHESTRATOR_ENABLED_DEFAULT   = false;
		public const CIAB_ADMIN_ORCHESTRATOR_ENABLED_DEFAULT = true;

		public static function init() {
			self::$enabled = get_option( self::ENABLE_OPTION_NAME, '1' );

			add_action( 'init', array( 'Big_Sky', 'load_textdomain' ) );

			add_action( 'init', array( 'Big_Sky', 'init_block_notes_features' ) );

			add_action( 'wp_abilities_api_categories_init', array( 'Big_Sky', 'register_ability_categories' ) );

			add_action( 'enqueue_block_editor_assets', array( 'Big_Sky', 'enqueue_assets' ) );

			add_action( 'current_screen', array( 'Big_Sky', 'maybe_enable_image_studio' ) );

			add_action( 'current_screen', array( 'Big_Sky', 'maybe_enable_block_notes' ) );

			// wp-admin unified orchestrator agent.
			// Shows on all wp-admin pages except the site editor.
			// Enable with: add_filter( 'big_sky_enable_wp_orchestrator_wp_admin_agent', '__return_true' );
			add_action( 'admin_enqueue_scripts', array( 'Big_Sky', 'enqueue_wp_orchestrator_wp_admin_assets' ) );
			add_action( 'admin_init', array( 'Big_Sky', 'maybe_register_wp_admin_chrome_hooks' ) );

			// CIAB Admin (Next Admin) unified orchestrator agent.
			// Disable with: add_filter( 'big_sky_enable_wp_orchestrator_ciab_admin_agent', '__return_false' );
			// Note: When Agents Manager is active and handles the agent via agents_manager_agent_providers,
			// we skip rendering Big Sky's own agent to avoid duplicates.
			add_action( 'next_admin_init', array( 'Big_Sky', 'maybe_enqueue_wp_orchestrator_ciab_admin_assets' ) );

			// Headless orchestrator for CIAB Admin (Next Admin) context.
			// Hook to next_admin_init to provide window.wpOrchestratorAgent for programmatic AI access.
			add_action( 'next_admin_init', array( 'Big_Sky', 'maybe_load_headless_orchestrator' ) );

			add_action( 'admin_init', array( 'Big_Sky', 'register_big_sky_enable' ) );
			add_action( 'admin_init', array( 'Big_Sky', 'register_big_sky_metadata_setting' ) );
			add_action( 'current_screen', array( 'Big_Sky', 'redirect_to_front_page' ) );
			add_action( 'rest_api_init', array( 'Big_Sky', 'register_big_sky_metadata_setting' ) );
			add_action( 'rest_api_init', array( 'Big_Sky', 'register_big_sky_rest_fields' ) );
			add_action( 'delete_post', array( 'Big_Sky', 'handle_post_deletion' ) );
			add_action( 'wp_trash_post', array( 'Big_Sky', 'handle_post_deletion' ) );
			add_action( 'admin_menu', array( 'Big_Sky', 'add_ai_editor_menu' ) );

			// Register main Orchestrator agent for Next Admin
			// TODO: Wrap this in a feature flag
			add_filter( 'next_admin_agent_providers', array( 'Big_Sky', 'register_wp_orchestrator_agent' ), 10, 1 );

			// Register Big Sky as an agent provider for the Agent's Manager (Jetpack)
			// This allows Big Sky's tools and context to be used by Agent Manager + Agents Manager's UnifiedAIAgent
			add_filter( 'agents_manager_agent_providers', array( 'Big_Sky', 'register_agent_manager_provider' ), 10, 1 );

			// Force Agents Manager to load in the block editor if the unified-big-sky flag is set.
			if ( self::is_unified_big_sky_flag_set() ) {
				add_filter( 'agents_manager_enabled_in_block_editor', '__return_true' );
			}

			// This will show a notice when in dev mode when requirements for Big Sky are not met.
			add_action( 'admin_notices', array( 'Big_Sky', 'admin_notices' ) );
			add_action( 'plugins_loaded', array( 'Big_Sky', 'maybe_disable_idc_validation' ) );

			// use the filter jetpack_options_whitelist to allow the big_sky_site_metadata option to be synced
			add_filter(
				'jetpack_options_whitelist',
				function ( $whitelist ) {
					$whitelist[] = 'big_sky_site_metadata';
					return $whitelist;
				}
			);

			// When an AI generated logo is edited, mark the new image as an AI generated logo as well.
			add_filter( 'wp_edited_image_metadata', array( 'Big_Sky', 'set_big_sky_generated_logo_for_edited_images' ), 10, 3 );

			// Exclude booking product types from the shop page on CIAB sites.
			if ( self::is_ciab_site() ) {
				add_action( 'pre_get_posts', array( 'Big_Sky', 'exclude_booking_products_from_shop' ) );
			}

			$logger = self::get_logger();

			// Register the endpoints.
			new WPCOM_REST_API_V2_Endpoint_Big_Sky_Plugin( $logger );
			self::init_site_health();
		}

		/**
		 * If true a feedback input will appear when thumbs down is clicked.
		 *
		 * @return bool True if the user is an internal tester, false otherwise.
		 */
		public static function is_internal_tester() {
			if ( apply_filters( 'big_sky_is_internal_tester', false ) ) {
				return true;
			}
			return self::is_dev_mode() || ( function_exists( 'is_automattician' ) && is_automattician() );
		}

		/**
		 * Enables "Development" features that should be accessible only for admins.
		 */
		public static function is_dev_mode() {
			// Known local environments.
			$domain = parse_url( get_site_url(), PHP_URL_HOST );
			if (
				$domain === 'localhost' ||
				'.jurassic.tube' === stristr( $domain, '.jurassic.tube' ) ||
				'.jurassic.ninja' === stristr( $domain, '.jurassic.ninja' )
			) {
				return true;
			}

			// A8C development.
			if ( self::is_wpcom() && is_proxied_automattician() ) {
				return true;
			}
			if ( defined( 'AT_PROXIED_REQUEST' ) && AT_PROXIED_REQUEST && defined( 'ATOMIC_CLIENT_ID' ) ) {
				switch ( ATOMIC_CLIENT_ID ) {
					case 1:
					case 2:
					case 3: // Pressable
					case 32:
					case 118: // Commerce garden client (ciab)
						return true;
						break;
				}
			}

			return false;
		}

		public static function is_ciab_site() {
			return defined( 'IS_COMMERCE_GARDEN' ) && IS_COMMERCE_GARDEN;
		}

		/**
		 * Exclude booking product types from the shop page on CIAB sites.
		 *
		 * @param \WP_Query $query The WP_Query instance.
		 */
		public static function exclude_booking_products_from_shop( $query ) {
			if ( ! is_admin()
				&& $query->is_main_query()
				&& is_shop()
			) {
				$tax_query = $query->get( 'tax_query', array() );

				$tax_query[] = array(
					'taxonomy' => 'product_type',
					'field'    => 'slug',
					'terms'    => array( 'booking', 'bookable-event', 'bookable-service' ),
					'operator' => 'NOT IN',
				);

				$query->set( 'tax_query', $tax_query );
			}
		}

		/**
		 * Conditionally enable Image Studio + orchestrator support for allowed screens.
		 *
		 * Orchestrator loading strategy:
		 * - If using agents manager, skip orchestrator loading.
		 * - For media library, post editor, and site-editor: Load headless orchestrator (functionality without UI)
		 *
		 * @param \WP_Screen $current_screen Current admin screen.
		 * @return void
		 */
		public static function maybe_enable_image_studio( $current_screen ) {
			if ( ! ( $current_screen instanceof \WP_Screen ) ) {
				return;
			}

			if ( ! self::should_enable_image_studio( $current_screen ) ) {
				return;
			}

			// Skip Image Studio loading if unified Big Sky is enabled (handled by Calypso/Jetpack).
			if ( self::is_agents_manager_handling_agent() ) {
				return;
			}

			// Skip Image Studio loading if Jetpack's image studio is enabled (e.g. in Self Hosted environments).
			if ( apply_filters( 'jetpack_image_studio_enabled', false ) ) {
				return;
			}

			// Add "Edit with AI" row action to supported images in the media library list view.
			if ( 'upload' === $current_screen->base ) {
				add_filter( 'media_row_actions', array( 'Big_Sky', 'add_image_studio_row_action' ), 10, 2 );
			}

			// Enqueue Image Studio assets for all enabled contexts.
			if ( ! has_action( 'admin_enqueue_scripts', array( 'Big_Sky', 'enqueue_image_studio_assets' ) ) ) {
				add_action( 'admin_enqueue_scripts', array( 'Big_Sky', 'enqueue_image_studio_assets' ), 100 );
			}

			// Disable Jetpack AI Image Extensions in block editor (runs at priority 99 to override Jetpack's default).
			$jetpack_hook                               = 'jetpack_register_gutenberg_extensions';
			$should_disable_jetpack_ai_image_extensions = self::is_block_editor_context() || self::is_site_editor_context();
			if ( $should_disable_jetpack_ai_image_extensions && ! has_action( $jetpack_hook, array( 'Big_Sky', 'disable_jetpack_ai_image_extensions' ) ) ) {
				add_action( $jetpack_hook, array( 'Big_Sky', 'disable_jetpack_ai_image_extensions' ), 99 );
			}

			// For media library, post editor, and site-editor: Load headless orchestrator (functionality without UI)
			// Currently required in post and site editor contexts as Big Sky loads a separate dock UI.
			$should_load_headless_orchestrator = in_array( $current_screen->base, array( 'upload', 'post', 'site-editor' ), true );
			if ( $should_load_headless_orchestrator && ! has_action( 'admin_enqueue_scripts', array( 'Big_Sky', 'maybe_load_headless_orchestrator' ) ) ) {
				add_action( 'admin_enqueue_scripts', array( 'Big_Sky', 'maybe_load_headless_orchestrator' ) );
			}
		}

		public static function maybe_enable_block_notes( $current_screen ) {
			if ( ! ( $current_screen instanceof \WP_Screen ) ) {
				return;
			}

			if ( ! self::should_enable_block_notes( $current_screen ) ) {
				return;
			}

			// Skip Block Notes loading if unified Big Sky is enabled (handled by Calypso/Jetpack).
			if ( self::is_agents_manager_handling_agent() ) {
				return;
			}

			// Skip Block Notes loading if Jetpack's block notes is enabled (e.g. in Self Hosted environments).
			if ( apply_filters( 'jetpack_block_notes_enabled', false ) ) {
				return;
			}

			if ( ! has_action( 'admin_enqueue_scripts', array( 'Big_Sky', 'enqueue_wp_orchestrator_headless' ) ) ) {
				add_action( 'admin_enqueue_scripts', array( 'Big_Sky', 'enqueue_wp_orchestrator_headless' ) );
			}

			// Separate bundle for Block Notes
			if ( ! has_action( 'admin_enqueue_scripts', array( 'Big_Sky', 'enqueue_block_notes_assets' ) ) ) {
				add_action( 'admin_enqueue_scripts', array( 'Big_Sky', 'enqueue_block_notes_assets' ) );
			}
		}

		/**
		 * Check if we have the unified-big-sky flag in query string.
		 *
		 * @return bool True if the unified-big-sky flag is in the query string, false otherwise.
		 */
		public static function is_unified_big_sky_flag_set() {
			if ( isset( $_GET['flags'] ) ) {
				$flags = explode( ',', sanitize_text_field( wp_unslash( $_GET['flags'] ) ) );
				if ( in_array( 'unified-big-sky', $flags, true ) ) {
					return true;
				}
			}

			return false;
		}

		/**
		 * Checks if Image Studio should be enabled.
		 *
		 * Image Studio is enabled for post editor, site editor, and media library
		 * contexts when the required assets exist.
		 *
		 * @param \WP_Screen|null $current_screen Optional current screen context.
		 * @return bool True if Image Studio should be enabled, false otherwise.
		 */
		public static function should_enable_image_studio( $current_screen = null ) {
			if ( ! self::image_studio_assets_exist() ) {
				return false;
			}

			if ( null === $current_screen ) {
				if ( ! function_exists( 'get_current_screen' ) ) {
					return false;
				}
				$current_screen = get_current_screen();
			}

			if ( ! ( $current_screen instanceof \WP_Screen ) ) {
				return false;
			}

			$allowed_screens = array( 'post', 'upload', 'site-editor' );

			return in_array( $current_screen->base, $allowed_screens, true );
		}

		/**
		 * Check if block notes feature should be enabled.
		 *
		 * The feature is enabled when:
		 * 1. Only enable for post editor
		 *
		 * @param \WP_Screen|null $current_screen Optional current screen context.
		 * @return bool True if block notes should be enabled, false otherwise.
		 */
		public static function should_enable_block_notes( $current_screen = null ) {
			// Block Notes is only for post editor context
			if ( $current_screen && ! self::is_post_editor_context() ) {
				return false;
			}

			return true;
		}

		/**
		 * Register ability categories for Big Sky
		 */
		public static function register_ability_categories() {
			wp_register_ability_category(
				'big-sky',
				array(
					'label'       => __( 'Big Sky', 'big-sky' ),
					'description' => __( 'AI-powered site building and navigation abilities.', 'big-sky' ),
				)
			);
		}

		private static function get_logger() {
			if ( self::is_wpcom() ) {
				require_once __DIR__ . '/lib/wpcom-big-sky-logger.php';
				return new WPCOM_Big_Sky_Logger();
			} else {
				require_once __DIR__ . '/lib/jetpack-big-sky-logger.php';
				return new Jetpack_Big_Sky_Logger();
			}
		}

		public static function is_wpcom() {
			return defined( 'IS_WPCOM' ) && IS_WPCOM;
		}

		public static function is_wpcom_simple_site() {
			if ( function_exists( 'get_site_type' ) && defined( 'SIMPLE_SITE' ) ) {
				return SIMPLE_SITE === get_site_type( get_current_blog_id() );
			}

			return self::is_wpcom()
				&& ! ( defined( 'IS_ATOMIC' ) && IS_ATOMIC )
				&& ! ( defined( 'ATOMIC_SITE_ID' ) && ATOMIC_SITE_ID )
				&& ! ( defined( 'ATOMIC_CLIENT_ID' ) && ATOMIC_CLIENT_ID );
		}

		public static function load_textdomain() {
			load_plugin_textdomain( 'big-sky', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
		}

		public static function enable_setting_html() {
			?>
			<label for="<?php echo esc_attr( self::ENABLE_OPTION_NAME ); ?>">
				<input name="<?php echo esc_attr( self::ENABLE_OPTION_NAME ); ?>" id="<?php echo esc_attr( self::ENABLE_OPTION_NAME ); ?>" <?php echo checked( self::$enabled, true, false ); ?> type="checkbox" value="1" />
				<?php esc_html_e( 'Enable AI-powered site building experience', 'big-sky' ); ?>
			</label>
			<?php
		}

		public static function register_big_sky_enable() {
			add_settings_field(
				self::ENABLE_OPTION_NAME,
				'<span>' . __( 'AI Features', 'big-sky' ) . '</span>',
				array( 'Big_Sky', 'enable_setting_html' ),
				'writing'
			);
			register_setting(
				'writing',
				self::ENABLE_OPTION_NAME,
				'intval'
			);
		}

		public static function redirect_to_front_page() {
			// Big Sky is disabled no action needed.
			$checks = self::do_checks();
			if ( 'critical' === $checks['status'] || ! self::$enabled ) {
				return;
			}

			if ( ! static::show_site_spec() ) {
				return; // Don't redirect if we are not showing the site spec.
			}

			$current_screen = get_current_screen();
			if ( 'site-editor' === $current_screen->base ) {
				$page_on_front = get_option( 'page_on_front' );

				// Use page_on_front if it's valid, otherwise fall back to root path (/)
				// This handles cases where reading settings are set to "Latest Posts" (page_on_front = 0)
				$p = $page_on_front && $page_on_front !== '0' ? '/page/' . $page_on_front : '/';
				if (
					( ! isset( $_GET['p'] ) || $_GET['p'] !== $p )
				) {
					$base_url   = admin_url( 'site-editor.php' );
					$query_args = array(
						'p'        => urlencode( $p ),
						'canvas'   => isset( $_GET['canvas'] ) ? sanitize_text_field( wp_unslash( $_GET['canvas'] ) ) : 'edit',
						'ai-step'  => isset( $_GET['ai-step'] ) ? sanitize_text_field( wp_unslash( $_GET['ai-step'] ) ) : '',
						'source'   => isset( $_GET['source'] ) ? sanitize_text_field( wp_unslash( $_GET['source'] ) ) : '',
						'referrer' => isset( $_GET['referrer'] ) ? sanitize_text_field( wp_unslash( $_GET['referrer'] ) ) : '',
					);

					if ( isset( $_GET['spec_id'] ) ) {
						$query_args['spec_id'] = sanitize_text_field( wp_unslash( $_GET['spec_id'] ) );
					} elseif ( isset( $_GET['prompt'] ) ) {
						$query_args['prompt'] = urlencode( sanitize_text_field( wp_unslash( $_GET['prompt'] ) ) );
					}

					wp_redirect( add_query_arg( $query_args, $base_url ) );
					exit;
				}
			}
		}

		public static function register_big_sky_metadata_setting() {
			register_post_meta(
				'attachment',
				'big_sky_generated_logo',
				[
					'type'          => 'integer',
					'description'   => 'If this attachment is a logo generated by Big Sky, the ID of the base/uncolorized generated logo or -1 if the attachment is the base/uncolorized generated logo. 0 if this attachment is not a logo generated by Big Sky.',
					'single'        => true,
					'default'       => 0,
					'show_in_rest'  => current_user_can( 'edit_theme_options' ),
					'auth_callback' => fn () => current_user_can( 'edit_theme_options' ),
				]
			);

			$args = array(
				'type'              => 'string',
				'sanitize_callback' => 'sanitize_text_field',
				'description'       => 'Settings for the Big Sky assembler',
				'show_in_rest'      => [
					'schema' => [
						'title' => __( 'Site Design Settings' ),
					],
				],
			);
			register_setting( 'options', 'big_sky_site_metadata', $args );
			register_post_meta(
				'page',
				'big_sky_generated',
				array(
					'show_in_rest' => true,
					'single'       => true,
					'type'         => 'boolean',
					'description'  => 'Whether the page is generated by Big Sky',
				)
			);
			if ( self::is_dev_mode() ) {
				register_setting(
					'options',
					'big_sky_last_site_design_payload',
					[
						'type'              => 'string',
						'sanitize_callback' => 'sanitize_text_field',
						'description'       => 'Last site design payload for debugging.',
						'show_in_rest'      => true,
					]
				);
			}
		}

		public static function register_big_sky_rest_fields() {
			add_filter( 'rest_request_after_callbacks', [ 'Big_Sky', 'add_big_sky_meta_to_global_styles' ], 10, 3 );
		}

		public static function add_big_sky_meta_to_global_styles( $response, $handler, WP_REST_Request $request ) {
			if ( ! $response instanceof WP_REST_Response ) {
				return $response;
			}

			if ( ! class_exists( 'WP_Theme_JSON_Resolver_Gutenberg' ) ) {
				return $response;
			}

			$theme_slug = get_option( 'stylesheet' );

			if ( ! str_contains( $request->get_route(), sprintf( 'global-styles/themes/%s/variations', $theme_slug ) ) ) {
				return $response;
			}

			if ( $response->is_error() ) {
				return $response;
			}

			$data     = $response->get_data();
			$raw_data = [];

			// Try reflection first
			try {
				$raw_files = new ReflectionProperty( 'WP_Theme_JSON_Resolver_Gutenberg', 'theme_json_file_cache' );
				$raw_files->setAccessible( true );
				foreach ( $raw_files->getValue() as $file => $file_data ) {
					$title              = $file_data['title'] ?? basename( $file, '.json' );
					$raw_data[ $title ] = $file_data;
				}
			} catch ( Exception $e ) {
				// If reflection fails, try reading theme files directly
				$theme_dir  = get_stylesheet_directory();
				$styles_dir = $theme_dir . '/styles';
				if ( is_dir( $styles_dir ) ) {
					foreach ( glob( $styles_dir . '/*.json' ) as $file ) {
						$file_data = json_decode( file_get_contents( $file ), true );
						if ( isset( $file_data['title'] ) ) {
							$raw_data[ $file_data['title'] ] = $file_data;
						}
					}
				}
			}

			foreach ( $data as &$variation ) {
				if ( isset( $variation['title'] ) ) {
					$variation['x-big-sky-meta'] = [
						'keywords'    => $raw_data[ $variation['title'] ]['keywords'] ?? [],
						'personality' => $raw_data[ $variation['title'] ]['personality'] ?? [],
					];
				}
			}

			$response->set_data( $data );

			return $response;
		}

		public static function init_site_health() {
			add_filter(
				'site_status_tests',
				function ( $tests ) {
					$tests['direct']['big_sky_checks'] = array(
						'name'  => __( 'Big Sky checks', 'big-sky' ),
						'label' => __( 'Big Sky checks', 'big-sky' ),
						'group' => 'direct',
						'test'  => array( __CLASS__, 'do_checks' ),
					);
					return $tests;
				}
			);
		}

		/**
		 * Do site-health page checks
		 *
		 * @access public
		 * @return array
		 */
		public static function do_checks() {
			$failures    = [];
			$passes      = [];
			$critical    = false;
			$is_e2e_test = ! empty( $_SERVER['SERVER_PORT'] ) && $_SERVER['SERVER_PORT'] === '8889'; // e2e run on 8889 port, less checking for that.
			/**
			 * Default, no issues found
			 */
			$result = array(
				'label'       => __( 'Big Sky Checks', 'big-sky' ),
				'status'      => 'good',
				'badge'       => array(
					'label' => __( 'Big Sky', 'big-sky' ),
					'color' => 'blue',
				),
				'description' => sprintf(
					'<p>%s</p>',
					__( 'Big Sky did not find any known issues with your site.', 'big-sky' )
				),
				'actions'     => '',
				'test'        => 'big_sky_checks',
			);

			if ( ! wp_is_block_theme() ) {
				$critical   = true;
				$failures[] = sprintf(
					'<p>%s</p>',
					__( 'The current theme is not a block theme. Big Sky requires a block theme to be active.', 'big-sky' )
				);
			} else {
				$theme_name = wp_get_theme()->get( 'Name' );
				$passes[]   = sprintf(
					'<p>%s</p>',
					// translators: %s is the theme name.
					sprintf( __( 'The current theme (%s) is a block theme.', 'big-sky' ), esc_html( $theme_name ) )
				);
			}

			// check that Jetpack is installed and active
			if ( ! self::is_wpcom() && ! class_exists( 'Jetpack' ) ) {
				$critical   = true;
				$failures[] = sprintf(
					'<p>%s</p>',
					__( 'Jetpack is not installed. Big Sky requires Jetpack to be installed and active.', 'big-sky' )
				);
			} else {
				$passes[] = sprintf(
					'<p>%s</p>',
					__( 'Jetpack is installed.', 'big-sky' )
				);
			}

			$check_jetpack_connection = apply_filters( 'big_sky_check_jetpack_connection', true );

			// check that Jetpack is connected
			if ( $check_jetpack_connection && ! self::is_wpcom() && class_exists( 'Jetpack' ) && ! Jetpack::connection()->is_connected() ) {
				$critical   = $is_e2e_test ? false : true; // not critical for e2e tests
				$failures[] = sprintf(
					'<p>%s</p>',
					__( 'Jetpack is not connected. Big Sky requires Jetpack to be connected.', 'big-sky' )
				);
			} else {
				$passes[] = sprintf(
					'<p>%s</p>',
					__( 'Jetpack is connected.', 'big-sky' )
				);
			}

			// do the same for Jetpack::connection()->has_connected_admin()
			if ( $check_jetpack_connection && ! self::is_wpcom() && class_exists( 'Jetpack' ) && ! Jetpack::connection()->has_connected_admin() ) {
				$critical   = $is_e2e_test ? false : true; // not critical for e2e tests
				$failures[] = sprintf(
					'<p>%s</p>',
					__( 'Jetpack does not have a connected admin. Big Sky requires Jetpack to be connected to an admin.', 'big-sky' )
				);
			} else {
				$passes[] = sprintf(
					'<p>%s</p>',
					__( 'Jetpack is connected to an admin.', 'big-sky' )
				);
			}

			// check that Jetpack_Options::get_option('mapbox_api_key') is set
			if ( ! self::is_wpcom() && class_exists( 'Jetpack_Mapbox_Helper' ) && ! Jetpack_Mapbox_Helper::get_access_token() ) {
				$failures[] = sprintf(
					'<p>%s</p>',
					__( 'Mapbox API key is not set. Big Sky requires a Mapbox API key to be set.', 'big-sky' )
				);
			} else {
				$passes[] = sprintf(
					'<p>%s</p>',
					__( 'Mapbox API key is set.', 'big-sky' )
				);
			}

			/**
			 * If issues found.
			 */
			if ( count( $failures ) > 0 ) {
				$result['status'] = $critical ? 'critical' : 'red';
				/* translators: $d is the number of performance issues found. */
				$result['label']       = sprintf( _n( 'Big Sky is affected by %d issue', 'Big Sky is affected by %d issues', count( $failures ), 'big-sky' ), count( $failures ) );
				$result['description'] = __( 'Big Sky detected the following issues with your site:', 'big-sky' );

				foreach ( $failures as $issue ) {
					$result['description'] .= '<p>';
					$result['description'] .= "<span class='dashicons dashicons-warning' style='color: crimson;'></span> &nbsp;";
					$result['description'] .= wp_kses( $issue, array( 'a' => array( 'href' => array() ) ) ); // Only allow a href HTML tags.
					$result['description'] .= '</p>';
				}
			}

			/**
			 * Add passes
			 */
			if ( count( $passes ) > 0 ) {
				$result['description'] .= __( 'These checks passed:', 'big-sky' );

				foreach ( $passes as $pass ) {
					$result['description'] .= '<p>';
					$result['description'] .= "<span class='dashicons dashicons-yes' style='color: green;'></span> &nbsp;";
					$result['description'] .= wp_kses( $pass, array( 'a' => array( 'href' => array() ) ) ); // Only allow a href HTML tags.
					$result['description'] .= '</p>';
				}
			}

			return $result;
		}

		public static function enqueue_assets() {
			if ( ! self::$enabled ) {
				return;
			}

			$current_screen = get_current_screen();
			if ( ! ( $current_screen instanceof \WP_Screen ) ) {
				return;
			}

			// Note: Block Notes (for 'post' type) is now bundled with wp-orchestrator, not Big Sky assembler
			// Site editor or post/page editor.
			$is_supported_screen = 'site-editor' === $current_screen->base ||
				( 'post' === $current_screen->base && in_array( $current_screen->post_type, array( 'page', 'post' ), true ) );

			if ( ! $is_supported_screen ) {
				return;
			}

			$checks = self::do_checks();
			if ( 'critical' === $checks['status'] ) {
				return;
			}

			wp_enqueue_script(
				'big-sky-assembler',
				plugins_url( 'build/index.js', __FILE__ ),
				[ 'wp-edit-site', 'wp-abilities' ],
				filemtime( plugin_dir_path( __FILE__ ) . 'build/index.js' )
			);

			wp_set_script_translations(
				'big-sky-assembler',
				'big-sky',
				plugin_dir_path( __FILE__ ) . 'languages'
			);

			wp_enqueue_style(
				'big-sky-assembler',
				plugins_url( 'build/style-index.css', __FILE__ ),
				[ 'wp-edit-site' ],
				filemtime( plugin_dir_path( __FILE__ ) . 'build/style-index.css' )
			);

			// Enqueue AgentUI styles
			wp_enqueue_style(
				'big-sky-agentui',
				plugins_url( 'build/index.css', __FILE__ ),
				[ 'big-sky-assembler' ],
				filemtime( plugin_dir_path( __FILE__ ) . 'build/index.css' )
			);

			// Enqueue site-spec assets from CDN only when dev mode is ON.
			wp_enqueue_script_module(
				'site-spec-bundle',
				'https://widgets.wp.com/site-spec/v1.6.0/index.js',
				[],
				null,
				[ 'in_footer' => true ]
			);

			wp_enqueue_style(
				'site-spec-styles',
				'https://widgets.wp.com/site-spec/v1.6.0/style.css',
				[],
				null
			);

			// Add inline script to notify when SiteSpec is ready
			wp_add_inline_script(
				'site-spec-bundle',
				'
			window.addEventListener("DOMContentLoaded", function() {
				if (typeof window.SiteSpec !== "undefined") {
					window.dispatchEvent(new CustomEvent("siteSpecReady"));
				}
			});
			'
			);

			// if user has more than 1 site, redirect to https://wordpress.com/sites on WP logo click
			if ( self::is_free_trial() ) {
				$blog_count = self::site_count();
				if ( $blog_count > 1 ) {
					wp_add_inline_script(
						'wp-edit-site',
						'
						wp.domReady( function () {
							var checkLogo = setInterval( function () {
								var logoLink = document.querySelector( ".edit-site-layout__view-mode-toggle" );
								if ( logoLink ) {
									logoLink.href = "https://wordpress.com/sites";
									clearInterval( checkLogo );
								}
							}, 100 );
						} );
						'
					);
				}
			}

			$user_locale = get_user_locale();
			if ( isset( static::SUPPORTED_LOCALES[ $user_locale ] ) ) {
				$user_language = static::SUPPORTED_LOCALES[ $user_locale ];
			} else {
				$user_locale   = 'en_US';
				$user_language = 'English (United States)';
			}

			wp_localize_script(
				'big-sky-assembler',
				'bigSkyInitialState',
				[
					'isDevMode'            => self::is_dev_mode(),
					'isInternalTester'     => self::is_internal_tester(),
					'isLocalGraph'         => false, // Change this to use local graph
					'launchStatus'         => get_option( 'launch-status' ),
					'userLocale'           => $user_locale,
					'userLanguage'         => $user_language,
					'isComingSoon'         => self::is_coming_soon(),
					'isBlogPrivate'        => self::is_blog_private(),
					'siteMetadata'         => json_decode( get_option( 'big_sky_site_metadata' ), true ),
					'siteIntent'           => get_option( 'site_intent', '' ),
					'siteGoals'            => get_option( 'site_goals', [] ),
					'currentScreen'        => [
						'screen'   => $current_screen->base,
						'postType' => $current_screen->post_type,
					],
					'isFreeTrial'          => self::is_free_trial(),
					'siteCount'            => self::site_count(),
					'maxUploadSize'        => wp_max_upload_size(),
					'bigSkyVersion'        => get_plugin_data( __FILE__ )['Version'] ?? '0',
					'woocommerce'          => self::is_woocommerce_active(),
					'wcAdminUrl'           => admin_url( 'admin.php?page=wc-admin' ),
					'isUnifiedChatEnabled' => self::is_agents_manager_handling_agent(),
					'isCiab'               => self::is_ciab_site(),
				]
			);
		}

		/**
		 * Registers wp-admin chrome hooks based on current context.
		 *
		 * Called on admin_init to conditionally register chrome hooks before admin_head fires.
		 * Only registers hooks if the wp-admin agent is enabled via filter.
		 */
		public static function maybe_register_wp_admin_chrome_hooks() {
			// Check filter before registering chrome hooks.
			// Default is false - must be explicitly enabled via filter.
			if ( false === apply_filters( 'big_sky_enable_wp_orchestrator_wp_admin_agent', self::WP_ADMIN_ORCHESTRATOR_ENABLED_DEFAULT ) ) {
				return;
			}

			// Skip chrome if Agents Manager is handling the agent.
			if ( self::is_agents_manager_handling_agent() ) {
				return;
			}

			if ( self::is_block_editor_context() ) {
				add_action( 'admin_head', array( 'Big_Sky_Chrome', 'inject_block_editor_chrome_css' ), 0 );
				add_action( 'admin_head', array( 'Big_Sky_Chrome', 'inject_block_editor_chrome_script' ), 2 );
			} elseif ( self::is_wp_admin_context() ) {
				add_action( 'admin_head', array( 'Big_Sky_Chrome', 'inject_wp_admin_chrome_css' ), 0 );
				add_action( 'admin_head', array( 'Big_Sky_Chrome', 'inject_wp_admin_chrome_script' ), 2 );
			}
		}

		/**
		 * Check if current context is Site Editor
		 *
		 * @return bool True if in Site Editor context
		 */
		private static function is_site_editor_context() {
			global $pagenow;
			return 'site-editor.php' === $pagenow;
		}

		/**
		 * Check if current context is CIAB Admin (Next Admin)
		 *
		 * @return bool True if in CIAB Admin context
		 */
		private static function is_ciab_admin_context() {
			return isset( $_GET['page'] ) && 'next-admin' === sanitize_text_field( wp_unslash( $_GET['page'] ) );
		}

		/**
		 * Check if current context is Block Editor (post.php or post-new.php)
		 *
		 * @return bool True if in Block Editor context
		 */
		private static function is_block_editor_context() {
			global $pagenow;
			return in_array( $pagenow, array( 'post.php', 'post-new.php' ), true );
		}

		/**
		 * Check if current context is Post Editor (Block Editor with post type 'post')
		 * This excludes Page Editor (BigSky) which has post type 'page'
		 *
		 * @return bool True if in Post Editor context
		 */
		private static function is_post_editor_context() {
			if ( ! self::is_block_editor_context() ) {
				return false;
			}

			$current_screen = get_current_screen();
			if ( ! ( $current_screen instanceof \WP_Screen ) ) {
				return false;
			}

			return 'post' === $current_screen->post_type;
		}

		/**
		 * Check if current context is regular wp-admin (not Site Editor, not Block Editor, not CIAB Admin)
		 *
		 * @return bool True if in regular wp-admin context
		 */
		private static function is_wp_admin_context() {
			return is_admin() && ! self::is_site_editor_context() && ! self::is_block_editor_context() && ! self::is_ciab_admin_context();
		}

		/**
		 * Filter callback to enable orchestrator for Image Studio in Post Editor context.
		 *
		 * This filter runs when the orchestrator checks whether to load (at admin_init/admin_enqueue_scripts).
		 * Returns true for Post Editor to enable full orchestrator with UI.
		 * Other contexts (Media Library) get headless orchestrator loaded separately.
		 *
		 * @since 6.8.2
		 * @param bool $enabled Current filter value.
		 * @return bool True if Post Editor context, otherwise original value.
		 */
		public static function maybe_enable_orchestrator_for_image_studio_filter( $enabled ) {
			// If already enabled by another filter, don't override.
			if ( $enabled ) {
				return $enabled;
			}
			// Enable full orchestrator for Post Editor context.
			return self::is_post_editor_context();
		}

		/**
		 * Load headless orchestrator in non-Post Editor contexts.
		 *
		 * Runs at admin_enqueue_scripts time. Loads headless variant for contexts
		 * that need orchestrator functionality (abilities, auth, window.wpOrchestratorAgent)
		 * but not the dock UI.
		 *
		 * @since 6.8.2
		 */
		public static function maybe_load_headless_orchestrator() {
			if ( ! self::$enabled ) {
				return;
			}

			// Only load headless if we're NOT in Post Editor.
			// Post Editor gets full orchestrator via the filter above.
			if ( ! self::is_post_editor_context() ) {
				self::enqueue_wp_orchestrator_headless();
			}
		}

		/**
		 * Enqueue wp-orchestrator headless variant (no UI)
		 *
		 * Full orchestrator functionality (abilities, auth, config) without rendering the dock UI.
		 * Exposes window.wpOrchestratorAgent for programmatic access to the AI agent.
		 * Used by Image Studio, Block Notes, CIAB Admin, and other features that need
		 * orchestrator capabilities without the dock interface.
		 */
		public static function enqueue_wp_orchestrator_headless() {
			if ( ! self::$enabled ) {
				return;
			}

			// Skip if full orchestrator with UI is enabled - prefer that over headless
			if ( apply_filters( 'big_sky_enable_wp_orchestrator_wp_admin_agent', false ) ) {
				return;
			}

			// Mark that orchestrator is loaded to prevent other variants from loading
			self::$orchestrator_loaded = true;

			// For non-WPCOM sites, ensure Jetpack connection state is initialized
			// This provides JP_CONNECTION_INITIAL_STATE needed for authentication
			if ( ! self::is_wpcom() && class_exists( 'Automattic\Jetpack\Connection\Initial_State' ) ) {
				\Automattic\Jetpack\Connection\Initial_State::render_script( 'big-sky-wp-orchestrator-headless' );
			}

			$build_path = plugin_dir_path( __FILE__ ) . 'build/wp-orchestrator/headless/';
			$build_url  = plugins_url( 'build/wp-orchestrator/headless/', __FILE__ );
			$asset_file = $build_path . 'index.asset.php';

			if ( ! file_exists( $build_path . 'index.js' ) || ! file_exists( $asset_file ) ) {
				return;
			}

			$asset = require $asset_file;

			wp_enqueue_script(
				'big-sky-wp-orchestrator-headless',
				$build_url . 'index.js',
				$asset['dependencies'] ?? array(),
				$asset['version'] ?? '1.0.0',
				true
			);

			wp_set_script_translations(
				'big-sky-wp-orchestrator-headless',
				'big-sky',
				plugin_dir_path( __FILE__ ) . 'languages'
			);

			// Set up Jetpack authentication data for WordPress.com sites
			// This is required for the orchestrator's authProvider to work
			if ( self::is_wpcom() ) {
				wp_add_inline_script(
					'big-sky-wp-orchestrator-headless',
					sprintf(
						'(function() {
							window.Jetpack_Editor_Initial_State = {
								...( window.Jetpack_Editor_Initial_State || {} ),
								wpcomBlogId: "%d"
							};
						})();',
						get_current_blog_id()
					),
					'before'
				);
			}

			// Extend bigSkyInitialState
			$additional_state = array(
				'isDevMode'        => self::is_dev_mode(),
				'isInternalTester' => self::is_internal_tester(),
				'bigSkyVersion'    => get_plugin_data( __FILE__ )['Version'] ?? '0',
				'pluginUrl'        => plugins_url( '', __FILE__ ),
			);

			wp_add_inline_script(
				'big-sky-wp-orchestrator-headless',
				'window.bigSkyInitialState = { ...( window.bigSkyInitialState || {} ), ...' . wp_json_encode( $additional_state ) . ' };',
				'before'
			);
		}

		/**
		 * Enqueue wp-admin agent assets
		 * Loads the embedded agent UI for classic wp-admin pages
		 */
		public static function enqueue_wp_orchestrator_wp_admin_assets() {
			// Big Sky globally disabled via settings.
			if ( ! self::$enabled ) {
				return;
			}

			// Skip if Agents Manager is handling the agent.
			if ( self::is_agents_manager_handling_agent() ) {
				return;
			}

			// Skip if orchestrator is already loaded (e.g., headless variant for Image Studio)
			if ( self::$orchestrator_loaded ) {
				return;
			}

			// Only load in wp-admin or block editor context.
			// Site editor uses main Big Sky Agent, CIAB Admin uses its own orchestrator.
			if ( ! self::is_wp_admin_context() && ! self::is_block_editor_context() ) {
				return;
			}

			// Allow other plugins to enable/disable the wp-admin agent.
			// Filter is only consulted when we're in appropriate context (checks above passed).
			// Default is false - must be explicitly enabled via filter.
			if ( false === apply_filters( 'big_sky_enable_wp_orchestrator_wp_admin_agent', self::WP_ADMIN_ORCHESTRATOR_ENABLED_DEFAULT ) ) {
				return;
			}

			// Mark that orchestrator is loaded
			self::$orchestrator_loaded = true;

			$build_path = plugin_dir_path( __FILE__ ) . 'build/wp-orchestrator/wp-admin/';
			$build_url  = plugins_url( 'build/wp-orchestrator/wp-admin/', __FILE__ );
			$asset_file = $build_path . 'index.asset.php';

			if ( ! file_exists( $build_path . 'index.js' ) || ! file_exists( $asset_file ) ) {
				return;
			}

			$asset = require $asset_file;

			wp_enqueue_script(
				'big-sky-wp-admin-agent',
				$build_url . 'index.js',
				$asset['dependencies'] ?? array(),
				$asset['version'] ?? '1.0.0',
				true
			);

			wp_enqueue_style(
				'big-sky-wp-admin-agent',
				$build_url . 'main.css',
				array(),
				$asset['version'] ?? '1.0.0'
			);

			wp_enqueue_style(
				'big-sky-wp-admin-agent-style',
				$build_url . 'style-main.css',
				array( 'big-sky-wp-admin-agent' ),
				$asset['version'] ?? '1.0.0'
			);

			wp_set_script_translations(
				'big-sky-wp-admin-agent',
				'big-sky',
				plugin_dir_path( __FILE__ ) . 'languages'
			);

			$current_screen = get_current_screen();
			wp_localize_script(
				'big-sky-wp-admin-agent',
				'bigSkyInitialState',
				[
					'isDevMode'        => self::is_dev_mode(),
					'isInternalTester' => self::is_internal_tester(),
					'currentScreen'    => [
						'screen'   => $current_screen->base,
						'postType' => $current_screen->post_type,
					],
				]
			);

			// Only set wpcomBlogId on WordPress.com sites
			if ( self::is_wpcom() ) {
				wp_add_inline_script(
					'big-sky-wp-admin-agent',
					sprintf(
						'(function() {
							window.bigSkyWpAdmin = { pluginUrl: %s };
							window.Jetpack_Editor_Initial_State = {
								...( window.Jetpack_Editor_Initial_State || {} ),
								wpcomBlogId: "%d"
							};
						})();',
						wp_json_encode( plugins_url( '', __FILE__ ) . '/' ),
						get_current_blog_id()
					),
					'before'
				);
			}
		}

		/**
		 * Check if Agents Manager is handling the agent.
		 *
		 * When Agents Manager is active and has any registered agent providers,
		 * Big Sky defers to Agents Manager to avoid rendering duplicate agent UIs.
		 *
		 * @return bool True if Agents Manager is handling the agent, false otherwise.
		 */
		public static function is_agents_manager_handling_agent() {
			if ( ! class_exists( '\A8C\FSE\Agents_Manager' ) || ! method_exists( '\A8C\FSE\Agents_Manager', 'is_enabled' ) ) {
				return false;
			}

			return \A8C\FSE\Agents_Manager::is_enabled();

			// Check if we've registered as a provider.
			// If the filter returns any providers, Agents Manager will handle the agent.
			$providers = apply_filters( 'agents_manager_agent_providers', array() );
			return ! empty( $providers );
		}

		/**
		 * Conditionally enqueue CIAB Admin orchestrator assets.
		 *
		 * Skips enqueuing if Agents Manager is handling the agent to avoid duplicate UIs.
		 */
		public static function maybe_enqueue_wp_orchestrator_ciab_admin_assets() {
			if ( self::is_agents_manager_handling_agent() ) {
				return;
			}

			self::enqueue_wp_orchestrator_ciab_admin_assets();
		}

		/**
		 * Enqueue CIAB Admin (Next Admin) orchestrator agent assets.
		 *
		 * Injects the Big Sky dock directly into CIAB Admin pages.
		 * Hooked to next_admin_init, so only runs within Next Admin context.
		 * Early exits ensure we only consult the filter when in appropriate context.
		 */
		public static function enqueue_wp_orchestrator_ciab_admin_assets() {
			// Big Sky globally disabled via settings.
			if ( ! self::$enabled ) {
				return;
			}

			// Exclude site editor - it has its own agent.
			if ( self::is_site_editor_context() ) {
				return;
			}

			// Check for critical issues (e.g., missing dependencies).
			$checks = self::do_checks();
			if ( 'critical' === $checks['status'] ) {
				return;
			}

			// Allow other plugins to disable the CIAB Admin agent.
			// Filter is only consulted when we're in appropriate context (checks above passed).
			// Default is true - enabled unless explicitly disabled via filter.
			if ( false === apply_filters( 'big_sky_enable_wp_orchestrator_ciab_admin_agent', self::CIAB_ADMIN_ORCHESTRATOR_ENABLED_DEFAULT ) ) {
				return;
			}

			// Use the same dock component as Site Editor (has both floating + docked modes)
			$build_path = plugin_dir_path( __FILE__ ) . 'build/wp-orchestrator/ciab-admin/';
			$build_url  = plugins_url( 'build/wp-orchestrator/ciab-admin/', __FILE__ );
			$asset_file = $build_path . 'index.asset.php';

			if ( ! file_exists( $build_path . 'index.js' ) || ! file_exists( $asset_file ) ) {
				return;
			}

			$asset = require $asset_file;

			wp_enqueue_script(
				'big-sky-ciab-admin-agent',
				$build_url . 'index.js',
				$asset['dependencies'] ?? array(),
				$asset['version'] ?? '1.0.0',
				true
			);

			wp_set_script_translations(
				'big-sky-ciab-admin-agent',
				'big-sky',
				plugin_dir_path( __FILE__ ) . 'languages'
			);

			// Set initial state for dev mode and other features
			wp_localize_script(
				'big-sky-ciab-admin-agent',
				'bigSkyInitialState',
				[
					'isDevMode'        => self::is_dev_mode(),
					'isInternalTester' => self::is_internal_tester(),
				]
			);

			// Enqueue styles - both main.css and style-main.css
			if ( file_exists( $build_path . 'main.css' ) ) {
				wp_enqueue_style(
					'big-sky-ciab-admin-agent-main',
					$build_url . 'main.css',
					array(),
					$asset['version'] ?? '1.0.0'
				);
			}

			if ( file_exists( $build_path . 'style-main.css' ) ) {
				wp_enqueue_style(
					'big-sky-ciab-admin-agent-style',
					$build_url . 'style-main.css',
					array( 'big-sky-ciab-admin-agent-main' ),
					$asset['version'] ?? '1.0.0'
				);
			}
		}

		/**
		 * Checks if Image Studio assets exist.
		 *
		 * This is used at initialization to conditionally register hooks,
		 * avoiding runtime checks on every request.
		 *
		 * @since 1.0.0
		 * @return bool True if all required assets exist, false otherwise.
		 */
		private static function image_studio_assets_exist() {
			$build_path = plugin_dir_path( __FILE__ ) . 'build/image-studio/';
			$js_file    = $build_path . 'image-studio.js';
			$asset_file = $build_path . 'image-studio.asset.php';
			$css_file   = $build_path . 'style-image-studio.css';

			return file_exists( $js_file ) && file_exists( $asset_file ) && file_exists( $css_file );
		}

		/**
		 * Enqueue assets for image studio integration
		 *
		 * @return void
		 */
		public static function enqueue_image_studio_assets() {
			if ( ! self::$enabled ) {
				return;
			}

			$current_screen = get_current_screen();
			if ( ! ( $current_screen instanceof \WP_Screen ) ) {
				return;
			}

			if ( ! self::image_studio_assets_exist() ) {
				return;
			}

			// Bail if Jetpack already loaded or registered Image Studio, or declared ownership via filter.
			if (
				wp_script_is( 'image-studio', 'enqueued' ) ||
				wp_script_is( 'image-studio', 'registered' ) ||
				apply_filters( 'jetpack_image_studio_enabled', false )
			) {
				return;
			}

			$build_path = plugin_dir_path( __FILE__ ) . 'build/image-studio/';
			$build_url  = plugins_url( 'build/image-studio/', __FILE__ );
			$asset_file = $build_path . 'image-studio.asset.php';

			$asset = require $asset_file;

			wp_enqueue_script(
				'big-sky-image-studio',
				$build_url . 'image-studio.js',
				$asset['dependencies'] ?? array(),
				$asset['version'] ?? '1.0.0',
				true
			);

			wp_set_script_translations(
				'big-sky-image-studio',
				'big-sky',
				plugin_dir_path( __FILE__ ) . 'languages'
			);

			wp_localize_script(
				'big-sky-image-studio',
				'bigSkyImageStudio',
				array(
					'enabled'              => true,
					'isUnifiedChatEnabled' => self::is_agents_manager_handling_agent(),
				)
			);

			wp_enqueue_style( 'wp-components' );

			wp_enqueue_style(
				'big-sky-image-studio-base',
				$build_url . 'image-studio.css',
				array( 'wp-components' ),
				$asset['version'] ?? '1.0.0'
			);

			wp_enqueue_style(
				'big-sky-image-studio',
				$build_url . 'style-image-studio.css',
				array( 'wp-components', 'big-sky-image-studio-base' ),
				$asset['version'] ?? '1.0.0'
			);
			wp_style_add_data( 'big-sky-image-studio', 'rtl', 'replace' );
		}

		/**
		 * Checks if Block Notes assets exist.
		 *
		 * This is used at initialization to conditionally register hooks.
		 *
		 * @return bool True if all required assets exist, false otherwise.
		 */
		private static function block_notes_assets_exist() {
			$build_path = plugin_dir_path( __FILE__ ) . 'build/block-notes/';
			$js_file    = $build_path . 'block-notes.js';
			$asset_file = $build_path . 'block-notes.asset.php';

			return file_exists( $js_file ) && file_exists( $asset_file );
		}

		/**
		 * Enqueue assets for Block Notes.
		 *
		 * Loads the Block Notes bundle as a separate script, matching Image Studio's pattern.
		 * The headless orchestrator provides ability registration; this bundle provides the UI.
		 *
		 * @return void
		 */
		public static function enqueue_block_notes_assets() {
			if ( ! self::$enabled ) {
				return;
			}

			if ( ! self::block_notes_assets_exist() ) {
				return;
			}

			$build_path   = plugin_dir_path( __FILE__ ) . 'build/block-notes/';
			$build_url    = plugins_url( 'build/block-notes/', __FILE__ );
			$asset_file   = $build_path . 'block-notes.asset.php';
			$asset        = require $asset_file;
			$dependencies = $asset['dependencies'] ?? array();

			// Ensure block-notes loads after the headless orchestrator when available.
			if ( wp_script_is( 'big-sky-wp-orchestrator-headless', 'registered' ) && ! in_array( 'big-sky-wp-orchestrator-headless', $dependencies, true ) ) {
				$dependencies[] = 'big-sky-wp-orchestrator-headless';
			}

			wp_enqueue_script(
				'big-sky-block-notes',
				$build_url . 'block-notes.js',
				$dependencies,
				$asset['version'] ?? '1.0.0',
				true
			);

			wp_set_script_translations(
				'big-sky-block-notes',
				'big-sky',
				plugin_dir_path( __FILE__ ) . 'languages'
			);

			// Provide feature flag + config
			wp_localize_script(
				'big-sky-block-notes',
				'bigSkyBlockNotes',
				array(
					'enabled' => true,
				)
			);
		}

		/**
		 * Disables Jetpack AI image generation extensions.
		 *
		 * @return void
		 */
		public static function disable_jetpack_ai_image_extensions() {
			if ( ! class_exists( 'Jetpack_Gutenberg' ) ) {
				return;
			}

			$extensions = array(
				'ai-featured-image-generator',
				'ai-assistant-image-extension',
				'ai-general-purpose-image-generator',
				'ai-assistant-experimental-image-generation-support',
			);

			$reason = 'big_sky_image_studio_enabled';

			foreach ( $extensions as $extension ) {
				\Jetpack_Gutenberg::set_extension_unavailable( $extension, $reason );
			}
		}

		/**
		 * Adds an "Edit with AI" row action for supported image types in the media library.
		 *
		 * @param array    $actions Row actions array.
		 * @param \WP_Post $post    The attachment post object.
		 * @return array Modified row actions.
		 */
		public static function add_image_studio_row_action( $actions, $post ) {
			// Keep in sync with IMAGE_STUDIO_SUPPORTED_MIME_TYPES in src/image-studio/types/index.ts.
			$supported_mime_types = array(
				'image/jpeg',
				'image/jpg',
				'image/png',
				'image/webp',
				'image/bmp',
				'image/tiff',
			);

			if ( ! in_array( $post->post_mime_type, $supported_mime_types, true ) ) {
				return $actions;
			}

			if ( ! current_user_can( 'edit_post', $post->ID ) ) {
				return $actions;
			}

			$link = sprintf(
				'<a href="#" class="big-sky-image-studio-link" data-attachment-id="%d">%s</a>',
				absint( $post->ID ),
				esc_html__( 'Edit with AI', 'big-sky' )
			);

			// Insert before the 'edit' action, or append if 'edit' is not present.
			$new_actions = array();
			foreach ( $actions as $key => $value ) {
				if ( 'edit' === $key ) {
					$new_actions['edit-with-ai'] = $link;
				}
				$new_actions[ $key ] = $value;
			}

			if ( ! isset( $new_actions['edit-with-ai'] ) ) {
				$new_actions['edit-with-ai'] = $link;
			}

			return $new_actions;
		}

		/**
		 * Whether the site is currently unlaunched or not.
		 * On WordPress.com and WoA, sites can be marked as "coming soon", aka unlaunched.
		 *
		 * See Jetpack_Status::is_coming_soon()
		 * https://github.com/Automattic/jetpack/blob/trunk/projects/packages/status/src/class-status.php
		 */
		public static function is_coming_soon() {
			return ( new \Automattic\Jetpack\Status() )->is_coming_soon();
		}

		/**
		 * See Jetpack_Status::is_private_site()
		 * https://github.com/Automattic/jetpack/blob/trunk/projects/packages/status/src/class-status.php
		 */
		public static function is_blog_private() {
			return ( new \Automattic\Jetpack\Status() )->is_private_site();
		}

		public static function is_free_trial() {
			$force_free_trial = false;

			// Check for e2e test conditions
			if ( isset( $_COOKIE['big_sky_force_free_trial'] ) && $_COOKIE['big_sky_force_free_trial'] === 'true' ) {
				$force_free_trial = true;
			}

			return $force_free_trial || ( self::is_wpcom() && big_sky_is_on_free_trial() );
		}

		public static function site_count() {
			return count( get_blogs_of_user( get_current_user_id() ) );
		}

		/**
		 * Displays admin notices.
		 */
		public static function maybe_disable_idc_validation() {
			if ( ! self::is_dev_mode() ) {
				return;
			}

			add_filter( 'jetpack_sync_error_idc_validation', '__return_false' );
		}

		/**
		 * Displays admin notices.
		 */
		public static function admin_notices() {
			if ( ! self::is_dev_mode() ) {
				return;
			}

			$checks = self::do_checks();

			if ( 'good' === $checks['status'] ) {
				return;
			}

			wp_admin_notice(
				$checks['description'],
				array(
					'type'        => 'error',
					'dismissible' => true,
				)
			);
		}

		/**
				 * If the original image was marked as an AI generated image, mark the new one as one as well.
				 */
		public static function set_big_sky_generated_logo_for_edited_images( $new_image_meta, $new_attachment_id, $attachment_id ) {
			$original = get_post_meta( $attachment_id, 'big_sky_generated_logo', true );
			if ( $original ) {
				add_post_meta( $new_attachment_id, 'big_sky_generated_logo', -1, true );
			}
			return $new_image_meta;
		}

		/**
		 * Handle post deletion by removing associated patterns from site metadata
		 *
		 * @param int $post_id The ID of the post being deleted
		 */
		public static function handle_post_deletion( $post_id ) {
			try {
				// Only process pages
				if ( 'page' !== get_post_type( $post_id ) ) {
					return;
				}

				// Get current site metadata
				$site_metadata = json_decode( get_option( 'big_sky_site_metadata' ), true );

				// If no patterns exist or patterns is not an object, return early
				if ( empty( $site_metadata['patterns'] ) || ! is_array( $site_metadata['patterns'] ) ) {
					return;
				}

				if ( ! isset( $site_metadata['patterns'][ $post_id ] ) ) {
					return;
				}

				// Remove patterns for the deleted post
				unset( $site_metadata['patterns'][ $post_id ] );

				// Update the site metadata
				update_option( 'big_sky_site_metadata', json_encode( $site_metadata ) );
			} catch ( Exception $e ) {
				// no big deal
				return;
			}
		}

		/**
		 * Initialize block notes features including note meta and avatar customization
		 *
		 * @since 6.5
		 * @return void
		 */
		public static function init_block_notes_features() {
			// Register meta field to track when note was processed by AI
			// Empty string means not processed, ISO date string means processed
			register_meta(
				'comment',
				'bigsky_ai_processed_date',
				array(
					'type'              => 'string',
					'description'       => 'ISO date when this note was processed by Big Sky AI (empty if not processed)',
					'single'            => true,
					'show_in_rest'      => true,
					'auth_callback'     => array( 'Big_Sky', 'bigsky_note_meta_auth_callback' ),
					'sanitize_callback' => 'sanitize_text_field',
				)
			);

			// Filter avatar URLs for WordPress AI notes
			// Lowering the priority to ensure it runs later and is not overridden.
			add_filter( 'get_avatar_data', array( 'Big_Sky', 'customize_wordpress_ai_avatar' ), 9999, 2 );
		}

		/**
		 * Customize avatar for WordPress AI notes based on author name
		 *
		 * @param array             $args        Avatar data array
		 * @param int|string|object $id_or_email User identifier
		 * @return array Modified avatar data
		 */
		public static function customize_wordpress_ai_avatar( $args, $id_or_email ) {
			// Check if this is a note object with author name
			if ( is_object( $id_or_email ) && isset( $id_or_email->comment_author ) ) {
				if ( 'AI [experimental]' === $id_or_email->comment_author ) {
					$big_sky_icon_url = plugins_url( 'assets/big-sky.svg', __FILE__ );
					$args['url']      = $big_sky_icon_url;
				}
			}

			return $args;
		}

		/**
		 * Auth callback for note meta: only allow users with edit_posts capability.
		 *
		 * @return bool True if user can update, false otherwise.
		 */
		public static function bigsky_note_meta_auth_callback() {
			return current_user_can( 'edit_posts' );
		}

		/**
		 * Check if the current theme is Assembler.
		 */
		protected static function is_assembler_theme() {
			return 'Assembler' === wp_get_theme()->get( 'Name' );
		}

		/**
		 * Check if WooCommerce plugin is installed and active
		 */
		protected static function is_woocommerce_active() {
			return (
				(
					class_exists( 'WooCommerce' ) && function_exists( 'WC' ) // This should work regardless of the way we load Woo.
				) ||
				(
					class_exists( 'WC_Dependencies' ) && WC_Dependencies::woocommerce_active_check() // Original check from woocommerce-subscriptions
				)
			);
		}

		/**
		 * Register wp-orchestrator agent provider for Next Admin
		 * This provides the unified agent configuration for Next Admin interface
		 *
		 * @param array $providers Existing agent provider module IDs.
		 * @return array Modified array of agent provider module IDs.
		 */
		public static function register_wp_orchestrator_agent( $providers ) {
			if ( ! is_array( $providers ) ) {
				$providers = array( $providers );
			}

			// Skip if Agents Manager is handling the agent to avoid duplicate UIs
			if ( self::is_agents_manager_handling_agent() ) {
				return $providers;
			}

			if ( ! defined( 'NEXT_ADMIN_PLUGIN_DIR' ) && ! function_exists( 'next_admin_url' ) ) {
				return $providers;
			}

			$build_path = plugin_dir_path( __FILE__ ) . 'build/wp-orchestrator/ciab-admin/';
			$build_url  = plugins_url( 'build/wp-orchestrator/ciab-admin/', __FILE__ );
			$asset_file = $build_path . 'index.asset.php';

			if ( ! file_exists( $build_path . 'index.js' ) || ! file_exists( $asset_file ) ) {
				return $providers;
			}

			$asset = require_once $asset_file;

			wp_register_script_module(
				'@big-sky/wp-orchestrator',
				$build_url . 'index.js',
				array(),
				$asset['version'] ?? '1.0.0'
			);

			if ( file_exists( $build_path . 'style-main.css' ) ) {
				wp_enqueue_style(
					'big-sky-wp-orchestrator',
					$build_url . 'style-main.css',
					array(),
					$asset['version'] ?? '1.0.0'
				);
			}

			$providers[] = '@big-sky/wp-orchestrator';

			return $providers;
		}

		/**
		 * Register Big Sky as an agent provider for Agents Manager.
		 *
		 * This allows Big Sky's tools and context to be consumed by
		 * Agents Manager's UnifiedAIAgent instead of rendering a separate agent.
		 *
		 * @param array $providers Existing agent provider URLs.
		 * @return array Modified array of agent provider URLs.
		 */
		public static function register_agent_manager_provider( $providers ) {
			if ( ! is_array( $providers ) ) {
				$providers = array();
			}

			// Only register if Big Sky is enabled
			if ( ! self::$enabled ) {
				return $providers;
			}

			$build_path = plugin_dir_path( __FILE__ ) . 'build/calypso-agent-provider/';
			$build_url  = plugins_url( 'build/calypso-agent-provider/', __FILE__ );
			$asset_file = $build_path . 'index.asset.php';

			// Check if the provider build exists
			if ( ! file_exists( $build_path . 'index.js' ) ) {
				return $providers;
			}

			$asset   = file_exists( $asset_file ) ? require $asset_file : array( 'version' => '1.0.0' );
			$version = $asset['version'] ?? '1.0.0';

			// Enqueue dependencies that the provider module needs
			// These must be loaded before the dynamic import happens
			$dependencies = $asset['dependencies'] ?? array();
			foreach ( $dependencies as $dep ) {
				if ( wp_script_is( $dep, 'registered' ) ) {
					wp_enqueue_script( $dep );
				}
			}

			// Enqueue chrome styles for Calypso agent provider
			if ( file_exists( $build_path . 'main.css' ) ) {
				wp_enqueue_style(
					'big-sky-calypso-agent-provider',
					$build_url . 'main.css',
					array(),
					$version
				);
			}

			// Enqueue component styles (ProductCard, etc.)
			if ( file_exists( $build_path . 'style-main.css' ) ) {
				wp_enqueue_style(
					'big-sky-calypso-agent-provider-components',
					$build_url . 'style-main.css',
					array( 'big-sky-calypso-agent-provider' ),
					$version
				);
			}

			// Return the full URL to the provider module for dynamic import
			// Include version for cache busting
			$providers[] = $build_url . 'index.js?ver=' . $version;

			return $providers;
		}

		/**
		 * Show site spec
		 * This is used to determine whether to show the site spec in the site editor.
		 * If the site is not onboarded and the theme is Assembler, we show the site spec.
		 * If the site is onboarded or the theme is not Assembler, we do not show the site spec.
		 *
		 * @return bool True if the site spec should be shown, false otherwise.
		 */
		protected static function show_site_spec() {
			$ai_step = isset( $_GET['ai-step'] ) ? sanitize_text_field( wp_unslash( $_GET['ai-step'] ) ) : false;
			if ( 'spec' === $ai_step ) {
				return true;
			}
			return false;
		}
		/**
		 * Add AI Editor menu item to WordPress admin
		 *
		 * @return void
		 */
		public static function add_ai_editor_menu() {
			// Only show if Big Sky is enabled and checks pass
			$checks = self::do_checks();
			if ( 'critical' === $checks['status'] || ! self::$enabled ) {
				return;
			}

			if ( self::is_wpcom_simple_site() && class_exists( 'Easy_Site_Editor' ) ) {
				$ai_editor_url = admin_url( 'admin.php?page=easy-site-editor' );
			} else {
				// Build the site editor URL directly.
				$page_on_front = get_option( 'page_on_front' );
				$p             = $page_on_front && $page_on_front !== '0' ? '/page/' . $page_on_front : '/';

				$base_url      = admin_url( 'site-editor.php' );
				$query_args    = array(
					'p'       => rawurlencode( $p ),
					'canvas'  => 'edit',
					'ai-open' => 'true',
				);
				$ai_editor_url = add_query_arg( $query_args, $base_url );
			}

			// Create data URI for Big Sky SVG icon
			$big_sky_svg   = '<svg width="400" height="400" viewBox="0 0 400 400" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M391.528 188.061L309.455 159.75C276.997 148.597 251.403 123.003 240.25 90.5451L211.939 8.47185C208.079 -2.82395 191.921 -2.82395 188.061 8.47185L159.75 90.5451C148.597 123.003 123.003 148.597 90.5451 159.75L8.47185 188.061C-2.82395 191.921 -2.82395 208.079 8.47185 211.939L90.5451 240.25C123.003 251.403 148.597 276.997 159.75 309.455L188.061 391.528C191.921 402.824 208.079 402.824 211.939 391.528L240.25 309.455C251.403 276.997 276.997 251.403 309.455 240.25L391.528 211.939C402.824 208.079 402.824 191.921 391.528 188.061ZM295.728 206.077L254.692 220.232C238.391 225.809 225.666 238.677 220.089 254.835L205.934 295.871C203.932 301.591 195.925 301.591 193.923 295.871L179.768 254.835C174.191 238.534 161.323 225.809 145.165 220.232L104.129 206.077C98.4093 204.075 98.4093 196.068 104.129 194.066L145.165 179.911C161.466 174.334 174.191 161.466 179.768 145.308L193.923 104.272C195.925 98.5523 203.932 98.5523 205.934 104.272L220.089 145.308C225.666 161.609 238.534 174.334 254.692 179.911L295.728 194.066C301.448 196.068 301.448 204.075 295.728 206.077Z" fill="white"/></svg>';
			$icon_data_uri = 'data:image/svg+xml;base64,' . base64_encode( $big_sky_svg );

			add_menu_page(
				__( 'AI Editor', 'big-sky' ),
				__( 'AI Editor', 'big-sky' ),
				'edit_theme_options',
				$ai_editor_url,
				'',
				$icon_data_uri,
				3
			);
		}

		/**
		 * Plugin activation handler
		 * Enables Big Sky when the plugin is activated
		 *
		 * @return void
		 */
		public static function activate() {
			update_option( self::ENABLE_OPTION_NAME, '1' );
		}

		/**
		 * Plugin deactivation handler
		 * Disables Big Sky when the plugin is deactivated
		 *
		 * @return void
		 */
		public static function deactivate() {
			update_option( self::ENABLE_OPTION_NAME, '0' );
		}

		/**
		 * Plugin uninstall handler
		 * Cleans up all Big Sky data when the plugin is deleted
		 *
		 * @return void
		 */
		public static function uninstall() {
			// Delete Big Sky options
			delete_option( self::ENABLE_OPTION_NAME );
		}
	}
} // close class_exists check

Big_Sky::init();

// Register plugin lifecycle hooks
register_activation_hook( __FILE__, array( 'Big_Sky', 'activate' ) );
register_deactivation_hook( __FILE__, array( 'Big_Sky', 'deactivate' ) );
register_uninstall_hook( __FILE__, array( 'Big_Sky', 'uninstall' ) );
