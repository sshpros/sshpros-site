<?php
if(!defined('ABSPATH')){ exit; }

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Typography;
use Directorist\Directorist_Listings;
use Directorist\Helper;

class GVAElement_Archive_Listing extends GVAElement_Base{
	const NAME = 'gva-archive-listing';
	const TEMPLATE = 'listing/archive-listing/';
	const CATEGORY = 'homirx_listing';

	public function get_name() {
		return self::NAME;
	}
	
	public function get_categories() {
		return array(self::CATEGORY);
	}

	public function get_title() {
		return esc_html__('Archive Listing', 'homirx-themer');
	}

	public function get_keywords() {
		return [ 'listings', 'archive', 'listing', 'content' ];
	}

	public function get_script_depends() {
		return [
			'gavias.elements'
		];
	}

	public function get_style_depends() {
		return array();
	}

	private function listing_categories() {
		$result = array();
		$categories = get_terms( ATBDP_CATEGORY );
		foreach ( $categories as $category ) {
			$result[$category->slug] = $category->name;
		}
		return $result;
	}

	private function listing_tags() {
		$result = array();
		$tags = get_terms( ATBDP_TAGS );
		foreach ( $tags as $tag ) {
			$result[$tag->slug] = $tag->name;
		}
		return $result;
	}

	private function listing_locations() {
		$result = array();
		$locations = get_terms( ATBDP_LOCATION );
		foreach ( $locations as $location ) {
			$result[$location->slug] = $location->name;
		}
		return $result;
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
      	'filter',
      	[
				'type'      => Controls_Manager::SWITCHER,
				'label'     => __( 'Show Filter Button?', 'homirx-themer' ),
				'default'   => 'yes'
			]
		);
      $this->add_control(
      	'view',
      	[
				'type'    => Controls_Manager::SELECT,
				'label'   => __( 'View As', 'homirx-themer' ),
				'options' => array(
					'grid' => __( 'Grid View', 'homirx-themer' ),
					'list' => __( 'List View', 'homirx-themer' ),
					'map'  => __( 'Map View', 'homirx-themer' ),
				),
				'default' => 'grid'
			]
		);

  		$this->add_control(
         'map_height',
         [
            'label'     => esc_html__('Map Height', 'homirx-themer'),
            'type'      => \Elementor\Controls_Manager::NUMBER,
            'default'   => 500,
            'condition' => [
               'view' => ['map']
            ]
         ]
      );
      $this->add_control(
      	'columns', 
      	[
				'type'    => Controls_Manager::SELECT,
				'id'      => 'columns',
				'label'   => __( 'Listings Per Row (Grid)', 'homirx-themer' ),
				'options' => array(
					'6' => __( '6 Items / Row', 'homirx-themer'  ),
					'4' => __( '4 Items / Row', 'homirx-themer'  ),
					'3' => __( '3 Items / Row', 'homirx-themer'  ),
					'2' => __( '2 Items / Row', 'homirx-themer'  ),
				),
				'default' => '3',
			]
		);
		$this->add_control(
         'list_view_col',
         [
            'label' => __( 'Listings Per Row (List)', 'homirx-themer' ),
            'type' => Controls_Manager::SELECT,
            'options' => [
              'list-col-1'      => esc_html__( '1 Item / Row', 'homirx-themer' ),
              'list-col-2'      => esc_html__( '2 Items / Row', 'homirx-themer' )
          ],
           'default' => 'list-col-2',
            'prefix_class' => '',
         ]
      );
		$this->add_control(
      	'sidebar',
      	[
				'type'      => Controls_Manager::SELECT,
				'label'     => __( 'Layout', 'homirx-themer' ),
				'options' => [
               'no_sidebar'      	=> esc_html__( 'Search Form Popup', 'homirx-themer' ),
               'left_sidebar'      	=> esc_html__( 'Left Sidebar', 'homirx-themer' ),
               'right_sidebar'      => esc_html__( 'Right Sidebar', 'homirx-themer' )
            ],
				'default'   => 'no_sidebar'
			]
		);
      $this->add_control(
         'card_style',
         [
            'label' => __( 'Style Property Style', 'homirx-themer' ),
            'type' => Controls_Manager::SELECT,
            'label_block'  => false,
            'options' => [
              'property-block-style-1'      => esc_html__( 'Item Style 01', 'homirx-themer' ),
              'property-block-style-2'      => esc_html__( 'Item Style 02', 'homirx-themer' ),
              'property-block-style-3'      => esc_html__( 'Item Style 03', 'homirx-themer' ),
              'property-block-style-4'      => esc_html__( 'Item Style 04', 'homirx-themer' )
          ],
           'default' => 'property-block-style-1',
            'prefix_class' => '',
         ]
      );
     	$this->add_control(
         'card_info',
         [
            'label' => __( 'Show/Hide Card Info', 'homirx-themer' ),
            'type' => Controls_Manager::SELECT,
            'label_block'  => false,
            'options' => [
              'card-info-show'      => esc_html__( 'Show', 'homirx-themer' ),
              'card-info-hidden'      => esc_html__( 'Hidden', 'homirx-themer' )
          ],
           'default' => 'card-info-show',
            'prefix_class' => '',
         ]
      );

     	

      $this->add_control(
         'view_as',
         [
            'label' => __( 'Show/Hide View As', 'homirx-themer' ),
            'type' => Controls_Manager::SELECT,
            'label_block'  => false,
            'options' => [
               'view-as-show'      => esc_html__( 'Show', 'homirx-themer' ),
              	'view-as-hide'      => esc_html__( 'Hidden', 'homirx-themer' )
          ],
           'default' => 'view-as-show',
            'prefix_class' => '',
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
	  		'preview',
	  		[
				'type'      => Controls_Manager::SWITCHER,
				'label'     => __( 'Show Preview Image?', 'homirx-themer' ),
				'default'   => 'yes'
			]
		);
	  	$this->add_control(
	  		'type',
	  		[
				'type'     => Controls_Manager::SELECT2,
				'label'    => __( 'Directory Types', 'homirx-themer' ),
				'multiple' => true,
				'options'  => $this->listing_types(),
				'condition' => directorist_is_multi_directory_enabled() ? '' : ['nocondition' => true]
			]
		);
		$this->add_control(
			'default_type',
			[
				'type'     => Controls_Manager::SELECT2,
				'label'    => __( 'Default Directory Types', 'homirx-themer' ),
				'options'  => $this->listing_types(),
				'condition' => directorist_is_multi_directory_enabled() ? '' : ['nocondition' => true],
			]
		);
		$this->add_control(
			'cat',
			[
				'type'     => Controls_Manager::SELECT2,
				'label'    => __( 'Specify Categories', 'homirx-themer' ),
				'multiple' => true,
				'options'  => $this->listing_categories()
			]
		);
		$this->add_control(
			'tag',
			[
				'type'     => Controls_Manager::SELECT2,
				'label'    => __( 'Specify Tags', 'homirx-themer' ),
				'multiple' => true,
				'options'  => $this->listing_tags()
			]
		);
		$this->add_control(
			'location',
			[
				'type'     => Controls_Manager::SELECT2,
				'label'    => __( 'Specify Locations', 'homirx-themer' ),
				'multiple' => true,
				'options'  => $this->listing_locations()
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
			'show_pagination',
			[
				'type'      => Controls_Manager::SWITCHER,
				'label'     => __( 'Show Pagination?', 'homirx-themer' ),
				'default'   => 'no',
			]
		);
		$this->end_controls_section();
	}

	protected function render() {
	  	$settings = $this->get_settings();
	  	$atts = array(
			'advanced_filter'       => $settings['filter'] ? $settings['filter'] : 'no',
			'view'                  => $settings['view'],
			'map_height'            => $settings['map_height'],
			'columns'               => $settings['columns'],
			'listings_per_page'     => $settings['listing_number'],
			'show_pagination'       => $settings['show_pagination'] ? $settings['show_pagination'] : 'no',
			'category'              => $settings['cat'] ? implode( ',', $settings['cat'] ) : '',
			'tag'                   => $settings['tag'] ? implode( ',', $settings['tag'] ) : '',
			'location'              => $settings['location'] ? implode( ',', $settings['location'] ) : '',
			'featured_only'         => $settings['featured'] ? $settings['featured'] : 'no',
			'popular_only'          => $settings['popular'] ? $settings['popular'] : 'no',
			'logged_in_user_only'   => $settings['user'] ? $settings['user'] : 'no',
			'display_preview_image' => $settings['preview'] ? $settings['preview'] : 'no',
			'orderby'               => $settings['order_by'],
			'order'                 => $settings['order_list'],
			'sidebar'					=> $settings['sidebar'],
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
		$atts = apply_filters( 'homirx_all_listings_elementor_widget_atts', $atts, $settings );
		foreach ( $atts as $key => $value ) {
			$html .= sprintf( ' %s="%s"', $key, esc_html( $value ) );
		}
		$html = sprintf( '[%s%s]', 'directorist_all_listing', $html );

	  	printf( '<div class="gva-element-%s gva-element %s">', $this->get_name(), $settings['card_style'] );
	  		echo do_shortcode( $html );
	  	print '</div>'; 
	}
}

$widgets_manager->register(new GVAElement_Archive_Listing());
