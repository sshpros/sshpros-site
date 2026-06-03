<?php
if(!defined('ABSPATH')){ exit; }

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Typography;
use Directorist\Directorist_Listings;
use Directorist\Helper;

class GVAElement_Search_Listing extends GVAElement_Base{
	const NAME = 'gva-search-listing';
	const TEMPLATE = 'listing/search-listing/';
	const CATEGORY = 'homirx_listing';

	public function get_name() {
		return self::NAME;
	}
	
	public function get_categories() {
		return array(self::CATEGORY);
	}

	public function get_title() {
		return esc_html__('Search Listing', 'homirx-themer');
	}

	public function get_keywords() {
		return [ 'listings', 'search', 'listing', 'content' ];
	}

	public function get_script_depends() {
		return [
			'swiper',
			'gavias.elements',
		];
	}

	public function get_style_depends() {
		return array('swiper');
	}

	private function listing_types() {
		$directories = directorist_get_directories();

		if ( is_wp_error( $directories ) || empty( $directories ) ) {
			return array();
		}
		return wp_list_pluck( $directories, 'name', 'slug' );
	}

	protected function register_controls() {
	  	$this->start_controls_section(
			'section_query',
			[
				'label' => esc_html__('General', 'homirx-themer'),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
	  	);
	  	$this->add_control(
         'style',
         [
            'label' => __( 'Style', 'homirx-themer' ),
            'type' => Controls_Manager::SELECT,
            'label_block'  => false,
            'options' => [
              'default'      	=> esc_html__( 'White', 'homirx-themer' ),
              'blur'      		=> esc_html__( 'Blur', 'homirx-themer' )
          ],
           'default' => 'blur',
         ]
      );
      $this->add_control(
      	'type',
      	[
				'type'     => Controls_Manager::SELECT2,
				'label'    => __( 'Directory Types', 'homirx-themer' ),
				'multiple' => true,
				'options'  => $this->listing_types()
			]
		);
		$this->add_control(
			'default_type',
			[
				'type'     => Controls_Manager::SELECT2,
				'label'    => __( 'Default Directory Types', 'homirx-themer' ),
				'options'  => $this->listing_types()
			]
		);
		$this->add_control(
         'type_align',
         [
            'label'     => esc_html__('Directory Types Align', 'homirx-themer'),
            'type'      => \Elementor\Controls_Manager::SELECT,
            'options' => [
               'nav-type-left'      	=> esc_html__( 'Nav Type Left', 'homirx-themer' ),
               'nav-type-center'      	=> esc_html__( 'Nav Type Center', 'homirx-themer' )
            ],
           'default' => 'nav-type-left',
           'prefix_class' => ''
         ]
      );
		$this->add_control(
			'search_btn_text',
			[
				'type'      => Controls_Manager::TEXT,
				'label'     => __( 'Search Button Label', 'homirx-themer' ),
				'default'   => __( 'Search', 'homirx-themer' )
			]
		);
		$this->add_control(
			'show_more_filter_btn',
			[
				'type'      => Controls_Manager::SWITCHER,
				'label'     => __( 'Show More Search Field?', 'homirx-themer' ),
				'default'   => 'yes',
			]
		);
		$this->add_control(
			'more_filter_btn_text',
			[
				'type'      => Controls_Manager::TEXT,
				'label'     => __( 'More Search Field Button Label', 'homirx-themer' ),
				'default'   => __( 'More', 'homirx-themer' ),
				'condition' => array( 'show_more_filter_btn' => 'yes' )
			]
		);
		$this->add_control(
			'more_filter_reset_btn',
			[
				'type'      => Controls_Manager::SWITCHER,
				'label'     => __( 'Show More Field Reset Button?', 'homirx-themer' ),
				'default'   => 'yes',
				'condition' => array( 'show_more_filter_btn' => 'yes' )
			]
		);
		$this->add_control(
			'more_filter_reset_btn_text',
			[
				'type'      => Controls_Manager::TEXT,
				'label'     => __( 'More Field Reset Button Label', 'homirx-themer' ),
				'default'   => __( 'Reset Filters', 'homirx-themer' ),
				'condition' => array( 'show_more_filter_btn' => 'yes', 'show_more_filter_btn' => 'yes' )
			]
		);
		$this->add_control(
			'more_filter_search_btn',
			[
				'type'      => Controls_Manager::SWITCHER,
				'label'     => __( 'Show More Field Search Button?', 'homirx-themer' ),
				'default'   => 'yes',
				'condition' => array( 'show_more_filter_btn' => 'yes')
			]
		);
		$this->add_control(
			'more_filter_search_btn_text',
			[
				'type'      => Controls_Manager::TEXT,
				'label'     => __( 'More Field Search Button Label', 'homirx-themer' ),
				'default'   => __( 'Apply Filters', 'homirx-themer' ),
				'condition' => array( 'show_more_filter_btn' => 'yes')
			]
		);
		$this->add_control(
			'user',
			[
				'type'      => Controls_Manager::SWITCHER,
				'label'     => __( 'Show only for logged in user?', 'homirx-themer' ),
				'default'   => 'no'
			]
		);
		$this->end_controls_section();
	}

	protected function render() {
	  	$settings = $this->get_settings();
	  	$atts = array(
	  		'show_title_subtitle'	=> 'no',
			'search_button_text'    => $settings['search_btn_text'],
			'more_filters_button'   => $settings['show_more_filter_btn'],
			'more_filters_text'     => $settings['more_filter_btn_text'],
			'reset_filters_button'  => $settings['more_filter_reset_btn'],
			'apply_filters_button'  => $settings['more_filter_search_btn'],
			'reset_filters_text'    => $settings['more_filter_reset_btn_text'],
			'apply_filters_text'    => $settings['more_filter_search_btn_text'],
			'logged_in_user_only'   => $settings['user'] ? $settings['user'] : 'no',
		);

	  	if ( directorist_is_multi_directory_enabled() ) {
			if ( $settings['type'] ) {
				$atts['directory_type'] = implode( ',', $settings['type'] );
			}
			if ( $settings['default_type'] ) {
				$atts['default_directory_type'] = $settings['default_type'];
			}
		}
		$html = '';
		$atts = apply_filters( 'homirx_search_listings_elementor_widget_atts', $atts, $settings );
		foreach ( $atts as $key => $value ) {
			$html .= sprintf( ' %s="%s"', $key, esc_html( $value ) );
		}
		$html = sprintf( '[%s%s]', 'directorist_search_listing', $html );

	  	printf( '<div class="gva-element-%s gva-element %s">', $this->get_name(), 'seach-form-style-' . $settings['style'] );
	  		echo do_shortcode( $html );
	  	print '</div>'; 
	}
}

$widgets_manager->register(new GVAElement_Search_Listing());
