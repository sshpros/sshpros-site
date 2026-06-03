<?php
/**
 * Big Sky Chrome Management
 *
 * Handles the injection of chrome (layout modifications around the main admin area) CSS and scripts for:
 * - WP Admin context (classic WordPress admin pages)
 * - Block Editor context (post.php, post-new.php)
 *
 * Chrome CSS is injected inline by PHP for instant rendering, then reused
 * by JavaScript for toggle operations without flicker.
 *
 * @package BigSky
 */

if ( ! class_exists( 'Big_Sky_Chrome' ) ) {
	/**
	 * Class Big_Sky_Chrome
	 *
	 * Manages chrome for the AI agent sidebar across
	 * different WordPress admin contexts.
	 */
	class Big_Sky_Chrome {

		/**
		 * Generate chrome removal script
		 * Shared logic for checking localStorage and conditionally removing chrome
		 *
		 * @param string $chrome_style_id The ID of the chrome style element.
		 * @param string $global_var_name The name of the global variable to store CSS.
		 */
		private static function get_chrome_script( $chrome_style_id, $global_var_name ) {
			?>
			(function() {
				// Store chrome CSS for later use
				var chromeStyle = document.getElementById('<?php echo esc_js( $chrome_style_id ); ?>');
				if (chromeStyle) {
					window.<?php echo esc_js( $global_var_name ); ?> = chromeStyle.textContent;
				}

				// Check if desktop size (matches useDockState.ts breakpoint)
				var isDesktop = window.matchMedia('(min-width: 1200px)').matches;

				// On mobile, always undock (ignore localStorage)
				if (!isDesktop) {
					if (chromeStyle) {
						chromeStyle.remove();
					}
					return;
				}

				// On desktop, check localStorage preferences
				var isDocked = true;
				try {
					var stored = localStorage.getItem('wp-orchestrator-docked');
					if (stored !== null) {
						isDocked = stored === 'true';
					}
				} catch (e) {}

				var isCollapsed = false;
				try {
					var chatState = localStorage.getItem('big-sky-orchestrator-chat-state');
					isCollapsed = chatState === 'collapsed';
				} catch (e) {}

				if (!isDocked || isCollapsed) {
					if (chromeStyle) {
						chromeStyle.remove();
					}
				}
			})();
			<?php
		}

		/**
		 * Inject wp-admin chrome CSS inline
		 * CSS applies to elements directly with for instant rendering
		 * Only applies to regular wp-admin pages (not CIAB Admin or Site Editor)
		 *
		 * @see src/constants/chrome-config.js::applyWpAdminChrome() - Captures and reuses this CSS
		 */
		public static function inject_wp_admin_chrome_css() {
			?>
			<style id="big-sky-wp-admin-chrome">
			body {
				background-color: #1e1e1e;
			}

			#wpadminbar {
				position: fixed;
				top: 16px;
				left: 16px;
				right: calc(350px + 8px);
				width: auto;
				border-radius: 8px 8px 0 0;
				border: 1px solid #545454;
				border-bottom: none;
			}

			#wpwrap {
				position: fixed;
				top: 48px;
				left: 16px;
				right: calc(350px + 8px);
				bottom: 16px;
				width: calc(100% - 350px - 24px);
				min-height: 0;
				box-sizing: border-box;
				border-radius: 0 0 8px 8px;
				border: 1px solid #545454;
				border-top: none;
				overflow-y: auto;
				overflow-x: hidden;
				background-color: #f0f0f1;
				margin: 0;
			}

			#wpwrap #adminmenuwrap {
				height: calc(100vh - 65px);
				width: 160px;
				border-bottom-left-radius: 8px;
			}

			#wpwrap #adminmenuback {
				bottom: inherit;
			}

			#wpwrap #wpadminbar #wp-admin-bar-notes #wpnt-notes-panel2 {
				top: 49px;
				bottom: 17px;
				right: 359px;
				border-bottom-right-radius: 8px;
				overflow: hidden;
			}

			#wpwrap #wpfooter {
				position: static;
			}

			#wpwrap #wpcontent {
				background-color: #f0f0f1;
				position: relative;
				margin-left: 160px;
				box-sizing: border-box;
			}

			#wpwrap #wpbody,
			#wpwrap #wpbody-content {
				background-color: #f0f0f1;
			}

			#wpwrap #wpbody-content {
				padding-bottom: 0;
			}
			</style>
			<?php
		}

		/**
		 * Script to remove chrome if undocked/collapsed
		 * This runs synchronously to check localStorage and remove chrome CSS if needed
		 * Only applies to regular wp-admin pages (not CIAB Admin or Site Editor)
		 */
		public static function inject_wp_admin_chrome_script() {
			?>
			<script id="big-sky-wp-admin-chrome-script">
			<?php self::get_chrome_script( 'big-sky-wp-admin-chrome', '__bigSkyWpAdminChromeCSS' ); ?>
			</script>
			<?php
		}

		/**
		 * Inject block editor chrome CSS inline
		 * CSS applies to block editor elements for the docked sidebar experience
		 * Similar to site editor but optimized for the block editor UI
		 *
		 * @see src/constants/chrome-config.js::applyBlockEditorChrome()
		 */
		public static function inject_block_editor_chrome_css() {
			?>
			<style id="big-sky-block-editor-chrome">
			.block-editor #editor {
				background-color: #1e1e1e;
			}

			.block-editor #editor .edit-post-layout {
				will-change: width, margin, border-radius;
				transition: width 0.2s cubic-bezier(0.4, 0, 0.2, 1),
							margin 0.2s cubic-bezier(0.4, 0, 0.2, 1),
							border-radius 0.2s cubic-bezier(0.4, 0, 0.2, 1);
				width: 100%;
			}

			.block-editor #editor.big-sky-sidebar-container--sidebar-open .edit-post-layout {
				width: calc(100% - 350px - 16px - 8px);
				margin: 16px 8px 16px 16px;
				border-radius: 8px;
				overflow: hidden;
			}
			</style>
			<?php
		}

		/**
		 * Inject inline script to remove block editor chrome if undocked/collapsed
		 * This runs synchronously to check localStorage and remove chrome CSS if needed
		 * Also stores CSS in a global variable so JS can capture it even after removal
		 */
		public static function inject_block_editor_chrome_script() {
			?>
			<script id="big-sky-block-editor-chrome-script">
			<?php self::get_chrome_script( 'big-sky-block-editor-chrome', '__bigSkyBlockEditorChromeCSS' ); ?>
			</script>
			<?php
		}
	}
}
