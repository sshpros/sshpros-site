<?php
if(!defined('ABSPATH')){ exit; }

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Typography;
use Directorist\Directorist_Listings;
use Directorist\Helper;

class GVAElement_All_Listings extends GVAElement_Base{
	const NAME = 'gva-all-listing';
	const TEMPLATE = 'listing/all-listing/';
	const CATEGORY = 'homirx_listing';

	public function get_name() {
		return self::NAME;
	}
	
	public function get_categories() {
		return array(self::CATEGORY);
	}

	public function get_title() {
		return esc_html__('All Listing', 'homirx-themer');
	}

	public function get_keywords() {
		return [ 'listings', 'content', 'carousel', 'grid' ];
	}

	public function get_script_depends() {
		return [
			'swiper',
			'gavias.elements',
			'directorist-all-listings'
		];
	}

	public function get_style_depends() {
		return array('swiper');
	}

	private function az_listing_categories() {
		$result = array();
		$categories = get_terms( ATBDP_CATEGORY );
		foreach ( $categories as $category ) {
			$result[$category->slug] = $category->name;
		}
		return $result;
	}

	private function az_listing_tags() {
		$result = array();
		$tags = get_terms( ATBDP_TAGS );
		foreach ( $tags as $tag ) {
			$result[$tag->slug] = $tag->name;
		}
		return $result;
	}

	private function az_listing_locations() {
		$result = array();
		$locations = get_terms( ATBDP_LOCATION );
		foreach ( $locations as $location ) {
			$result[$location->slug] = $location->name;
		}
		return $result;
	}

	private function az_listing_types() {
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
         'type_nav',
         [
            'type'      => Controls_Manager::SWITCHER,
            'label'     => __( 'Show Types Navigate?', 'homirx-themer' ),
            'default'   => 'yes'
         ]
      );
		$this->add_control(
		 	'layout',
		 	[
				'label' => esc_html__( 'Layout', 'homirx-themer' ),
				'type' => Controls_Manager::SELECT,
				'options' => array(
					'carousel' 	=> __( 'Carousel', 'homirx-themer' ),
					'grid' 		=> __( 'Grid', 'homirx-themer' ),
				),
				'default' => 'grid',
		 	]
		);
      $this->add_control(
         'property_layout',
         [
            'label'     => esc_html__('Property Item Layout', 'homirx-themer'),
            'type'      => \Elementor\Controls_Manager::SELECT,
            'options' => [
               'grid'      => esc_html__( 'Item Grid Layout', 'homirx-themer' ),
               'list'      => esc_html__( 'item List Layout', 'homirx-themer' )
            ],
           'default' => 'grid'
         ]
      );
      $this->add_control(
         'card_style',
         [
             'label'     => esc_html__('Style', 'homirx-themer'),
             'type'      => \Elementor\Controls_Manager::SELECT,
             'options' => [
                 'property-block-style-1'      => esc_html__( 'Item Style 01', 'homirx-themer' ),
                 'property-block-style-2'      => esc_html__( 'Item Style 02', 'homirx-themer' ),
                 'property-block-style-3'      => esc_html__( 'Item Style 03', 'homirx-themer' )
             ],
              'default' => 'property-block-style-1',
              'condition' => [
                  'property_layout' => ['grid']
               ]
         ]
      );
	  	$this->add_control(
			'listing_number',
			[
				'label' => esc_html__( 'Number of Listings to Show', 'homirx-themer' ),
				'type' => Controls_Manager::NUMBER,
				'min'       => 1,
				'max'       => 100,
				'step'      => 1,
				'default'   => 6,
			]
	  	);
	  	$this->add_control(
	  		'type',
	  		[
				'type'     => Controls_Manager::SELECT2,
				'label'    => __( 'Directory Types', 'homirx-themer' ),
				'multiple' => true,
				'options'  => $this->az_listing_types(),
				'condition' => directorist_is_multi_directory_enabled() ? '' : ['nocondition' => true]
			]
		);
		$this->add_control(
			'default_type',
			[
				'type'     => Controls_Manager::SELECT2,
				'label'    => __( 'Default Directory Types', 'homirx-themer' ),
				'options'  => $this->az_listing_types(),
				'condition' => directorist_is_multi_directory_enabled() ? '' : ['nocondition' => true],
			]
		);
		$this->add_control(
			'cat',
			[
				'type'     => Controls_Manager::SELECT2,
				'label'    => __( 'Specify Categories', 'homirx-themer' ),
				'multiple' => true,
				'options'  => $this->az_listing_categories()
			]
		);
		$this->add_control(
			'tag',
			[
				'type'     => Controls_Manager::SELECT2,
				'label'    => __( 'Specify Tags', 'homirx-themer' ),
				'multiple' => true,
				'options'  => $this->az_listing_tags()
			]
		);
		$this->add_control(
			'location',
			[
				'type'     => Controls_Manager::SELECT2,
				'label'    => __( 'Specify Locations', 'homirx-themer' ),
				'multiple' => true,
				'options'  => $this->az_listing_locations()
			]
		);
		$this->add_control(
			'featured',
			[
				'type'      => Controls_Manager::SWITCHER,
				'label'     => __( 'Show Featured Only?', 'homirx-themer' ),
				'default'   => 'no'
			]
		);
		$this->add_control(
			'popular',
			[
				'type'      => Controls_Manager::SWITCHER,
				'label'     => __( 'Show Popular Only?', 'homirx-themer' ),
				'default'   => 'no'
			]
		);
		$this->add_control(
			'user',
			[
				'type'      => Controls_Manager::SWITCHER,
				'label'     => __( 'Only For Logged In User?', 'homirx-themer' ),
				'default'   => 'no'
			]
		);
		$this->add_control(
			'order_by',
			[
				'type'    => Controls_Manager::SELECT,
				'label'   => __( 'Order by', 'homirx-themer' ),
				'options' => array(
					'title' => __( 'Title', 'homirx-themer' ),
					'date'  => __( 'Date', 'homirx-themer' ),
					'price' => __( 'Price', 'homirx-themer' ),
				),
				'default' => 'date',
			]
		);
		$this->add_control(
			'order_list',
			[
				'type'    => Controls_Manager::SELECT,
				'label'   => __( 'Listings Order', 'homirx-themer' ),
				'options' => array(
					'asc'  => __( ' ASC', 'homirx-themer' ),
					'desc' => __( ' DESC', 'homirx-themer' ),
				),
				'default' => 'desc'
			]
		);
		

	  	$this->add_control(
			'image_size',
			[
				'label'     => esc_html__('Image Size', 'homirx-themer'),
				'type'      => \Elementor\Controls_Manager::SELECT,
				'options'   => $this->get_thumbnail_size(),
				'default'   => 'homirx_medium'
			]
		);

		$this->end_controls_section();

		$this->add_control_carousel(false, array('layout' => 'carousel'));

		$this->add_control_grid(array('layout' => 'grid'));

	}

	protected function render() {
	  	$settings = $this->get_settings();
	  	$atts = array(
         'header'                => 'no',
			'listings_per_page'     => $settings['listing_number'],
			'show_pagination'       => 'no',
			'category'              => $settings['cat'] ? implode( ',', $settings['cat'] ) : '',
			'tag'                   => $settings['tag'] ? implode( ',', $settings['tag'] ) : '',
			'location'              => $settings['location'] ? implode( ',', $settings['location'] ) : '',
			'featured_only'         => $settings['featured'] ? $settings['featured'] : 'no',
			'popular_only'          => $settings['popular'] ? $settings['popular'] : 'no',
			'logged_in_user_only'   => $settings['user'] ? $settings['user'] : 'no',
			'display_preview_image' => 'yes',
			'orderby'               => $settings['order_by'],
			'order'                 => $settings['order_list'],
			'layout'						=> $settings['layout'],
         'property_layout'       => $settings['property_layout']
		);
      if($settings['layout'] == 'carousel'){
         $atts['carousel'] = array(
            'ca_pagination'         => isset($settings['ca_pagination']) && $settings['ca_pagination'] ? 1: 0,
            'ca_navigation'         => isset($settings['ca_navigation']) && $settings['ca_navigation'] ? 1: 0
         );
      }
      
	  	if ( directorist_is_multi_directory_enabled() ) {
			if ( $settings['type'] ) {
				$atts['directory_type'] = implode( ',', $settings['type'] );
			}
			if ( $settings['default_type'] ) {
				$atts['default_directory_type'] = $settings['default_type'];
			}
		}
	  	printf( '<div class="gva-element-%s gva-element %s">', $this->get_name(), $settings['card_style'] );
	  	$listings = new Directorist_Listings( $atts );
	  	ob_start();

	  	// Load the template
		//Helper::get_template( 'archive-contents', array( 'listings' => $listings ), '' );
		if( !empty($settings['layout']) ){
			include $this->get_template(self::TEMPLATE . $settings['layout'] . '.php');
	  	}
		print ob_get_clean();
	  
	  	print '</div>'; 
	}

}

$widgets_manager->register(new GVAElement_All_Listings());
