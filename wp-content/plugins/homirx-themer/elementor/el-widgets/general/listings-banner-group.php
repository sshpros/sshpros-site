<?php
if(!defined('ABSPATH')){ exit; }

use Elementor\Controls_Manager;
use Elementor\Utils;
use Elementor\Scheme_Color;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Image_Size;
use Elementor\Repeater;
use Elementor\Icons_Manager;

class GVAElement_Listings_Banner_Group extends GVAElement_Base{
	const NAME = 'gva-listings-banner-group';
	const TEMPLATE = 'general/banner-group/';
	const CATEGORY = 'homirx_general';

	public function get_name() {
		return self::NAME;
	}
	
	public function get_categories() {
		return array(self::CATEGORY);
	}

	public function get_title() {
		return __('Listing Banners Group', 'homirx-themer');
	}

	public function get_keywords() {
		return [ 'listings', 'banner', 'content', 'group', 'carousel', 'grid' ];
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

	protected function register_controls() {
		$this->start_controls_section(
			'section_content',
			[
				'label' => __('Content', 'homirx-themer'),
			]
		);
		$this->add_control(
			'style',
			[
				'label' => __( 'Style', 'homirx-themer' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
				  'style-1' => esc_html__('Style 01', 'homirx-themer'),
				  'style-2' => esc_html__('Style 02', 'homirx-themer'),
				  'style-3' => esc_html__('Style 03', 'homirx-themer')
				],
				'default' => 'style-1',
			]
		);

		$repeater = new Repeater();
		
		$repeater->add_control(
			'sub_title',
		  	[
				'label'       => __('Sub Title', 'homirx-themer'),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Add your Sub-Title', 'homirx-themer' ),
				'label_block' => true,
				'default'     => esc_html__('Places in', 'homirx-themer')
		  	]
		);
		$repeater->add_control(
			'title',
		  [
			 'label'       => __('Title', 'homirx-themer'),
			 'type'        => Controls_Manager::TEXT,
			 'placeholder' => esc_html__( 'Add your Title', 'homirx-themer' ),
			 'label_block' => true,
			 'default'     => 'London',
		  ]
		);

		if(class_exists('ATBDP_Listing')){
			$repeater->add_control(
				'taxonomy',
				[
					'label' => __( 'Taxonomy', 'homirx-themer' ),
					'type' => Controls_Manager::SELECT,
					'options' => [
					  	ATBDP_TYPE => esc_html__('Type', 'homirx-themer'),
					  'at_biz_dir-location' => esc_html__('Location', 'homirx-themer'),
					  'at_biz_dir-category' => esc_html__('Category', 'homirx-themer'),
					],
					'default' => 'at_biz_dir-location',
				]
			);
			$repeater->add_control(
				'term_slug',
				[
					'label'       	=> esc_html__('Term Slug', 'homirx-themer'),
					'type'        	=> Controls_Manager::TEXT,
					'placeholder'	=> esc_html__('ex: villa', 'homirx-themer'),
					'default'	  	=> ''
				]
			);
		}
		$repeater->add_control(
			'link',
		  [
			 'label'       => __('Link', 'homirx-themer'),
			 'type'        => Controls_Manager::URL,
			 'placeholder' => esc_html__( 'Add Your Link', 'homirx-themer' ),
		  ]
		);
		$repeater->add_control(
			'image',
		  [
			 'label'      => __('Choose Image', 'homirx-themer'),
			 'default'    => [
				  'url' => GAVIAS_HOMIRX_PLUGIN_URL . 'elementor/assets/images/banner-1.jpg',
			 ],
			 'dynamic' => [
				'active' => true,
			 ],
			 'type'       => Controls_Manager::MEDIA,
			 'show_label' => false,
		  ]
		);

		$repeater->add_control(
			'item_active',
			[
				'label'   => __( 'Active', 'homirx-themer' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'no'
			]
		);

		 $this->add_control(
			 'content_banners',
			 [
				'label'       => __('Listings Banner Content', 'homirx-themer'),
				'type'        => Controls_Manager::REPEATER,
				 'fields' => $repeater->get_controls(),
				'title_field' => '{{{ title }}}',
				'default'     => array(
				  array(
						'sub_title'  	=> esc_html__( 'Places in', 'homirx-themer' ),
						'title'  		=> esc_html__( 'London', 'homirx-themer' ),
						'image'			=> ['url' => GAVIAS_HOMIRX_PLUGIN_URL . 'elementor/assets/images/banner-1.jpg']
				  ),
				  array(
						'sub_title'  	=> esc_html__( 'Enjoy in', 'homirx-themer' ),
						'title'       => esc_html__( 'Dubai', 'homirx-themer' ),
						'image'			=> ['url' => GAVIAS_HOMIRX_PLUGIN_URL . 'elementor/assets/images/banner-2.jpg']
				  ),
				  array(
						'sub_title'  	=> esc_html__( 'Travel to', 'homirx-themer' ),
						'title'  		=> esc_html__( 'Turkey', 'homirx-themer' ),
						'image'			=> ['url' => GAVIAS_HOMIRX_PLUGIN_URL . 'elementor/assets/images/banner-3.jpg']
				  ),
				  array(
						'sub_title'  	=> esc_html__( 'Eat in', 'homirx-themer' ),
						'title'  		=> esc_html__( 'New York', 'homirx-themer' ),
						'image'			=> ['url' => GAVIAS_HOMIRX_PLUGIN_URL . 'elementor/assets/images/banner-4.jpg']
				  ),
				)
			 ]
		  );
		  $this->add_control( // xx Layout
				'layout_heading',
				[
					 'label'   => __( 'Layout', 'homirx-themer' ),
					 'type'    => Controls_Manager::HEADING,
				]
		  );
			$this->add_control(
				'layout',
				[
					 'label'   => __( 'Layout Display', 'homirx-themer' ),
					 'type'    => Controls_Manager::SELECT,
					 'default' => 'carousel',
					 'options' => [
						  'grid'      => __( 'Grid', 'homirx-themer' ),
						  'carousel'  => __( 'Carousel', 'homirx-themer' ),
					 ]
				]
		  );

		  $this->add_control(
			 'show_number_content',
			 [
				'label'   => __( 'Show number content', 'homirx-themer' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes'
			 ]
		  );
  
		  
		  $this->add_control(
				'image_size',
				[
					'label'     => __('Image Size', 'homirx-themer'),
					'type'      => \Elementor\Controls_Manager::SELECT,
					'options'   => $this->get_thumbnail_size(),
					'default'   => 'full'
				]
			);

		 

		  $this->end_controls_section();

		  $this->add_control_carousel(false, array('layout' => 'carousel'));

		  $this->add_control_grid(array('layout' => 'grid'));

		  // Icon Styling
		  $this->start_controls_section(
			 'section_style_icon',
			 [
				'label' => __( 'Icon', 'homirx-themer' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			 ]
		  );

		  $this->add_control(
			 'icon_color',
			 [
				'label' => __( 'Icon Color', 'homirx-themer' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
				  '{{WRAPPER}} .gsc-icon-box-group .icon-box-item-content .box-icon i' => 'color: {{VALUE}};',
				  '{{WRAPPER}} .gsc-icon-box-group .icon-box-item-content svg' => 'fill: {{VALUE}};'
				],
			 ]
		  );

		  $this->add_responsive_control(
			 'icon_size',
			 [
				'label' => __( 'Size', 'homirx-themer' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
				  'size' => 60
				],
				'range' => [
				  'px' => [
					 'min' => 20,
					 'max' => 80,
				  ],
				],
				'selectors' => [
				  '{{WRAPPER}} .gsc-icon-box-group .icon-box-item-content .box-icon i' => 'font-size: {{SIZE}}{{UNIT}};',
				  '{{WRAPPER}} .gsc-icon-box-group .icon-box-item-content .box-icon svg' => 'width: {{SIZE}}{{UNIT}};'
				],
			 ]
		  );

		  $this->add_responsive_control(
			 'icon_space',
			 [
				'label' => __( 'Spacing', 'homirx-themer' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
				  'size' => 0,
				],
				'range' => [
				  'px' => [
					 'min' => 0,
					 'max' => 50,
				  ],
				],
				'selectors' => [
				  '{{WRAPPER}} .gsc-icon-box-group .icon-box-item-content .icon-inner' => 'padding-bottom: {{SIZE}}{{UNIT}};',
				],
			 ]
		  );

	  	$this->add_responsive_control(
		 	'icon_padding',
		 	[
				'label' => __( 'Padding', 'homirx-themer' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
				  	'{{WRAPPER}} .gsc-icon-box-group .icon-box-item-content .icon-inner .box-icon' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				]
		 	]
	  	);

		$this->end_controls_section();

	  	$this->start_controls_section(
		 	'section_style_content',
		 	[
				'label' => __( 'Content', 'homirx-themer' ),
				'tab'   => Controls_Manager::TAB_STYLE,
		 	]
	  	);

	  	$this->add_control(
		 	'heading_title',
		 	[
				'label' => __( 'Title', 'homirx-themer' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
		 	]
	  	);

	  	$this->add_responsive_control(
		 	'title_bottom_space',
		 	[
				'label' => __( 'Spacing', 'homirx-themer' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
				  'px' => [
					 	'min' => 0,
					 	'max' => 100,
				  	],
				],
				'default' => [
				  'size'  => 5
				],
				'selectors' => [
				  '{{WRAPPER}} .gsc-icon-box-group .icon-box-item-content .title' => 'padding-bottom: {{SIZE}}{{UNIT}};',
				]
		 	]
	  	); 

	  	$this->add_control(
		 	'title_color',
		 	[
				'label' => __( 'Color', 'homirx-themer' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
				  '{{WRAPPER}} .gsc-icon-box-group .icon-box-item-content .title' => 'color: {{VALUE}};',
				  '{{WRAPPER}} .gsc-icon-box-group .icon-box-item-content .title a' => 'color: {{VALUE}};',
				]
		 	]
	  	);

	  	$this->add_group_control(
		 	Group_Control_Typography::get_type(),
		 	[
				'name' => 'title_typography',
				'selector' => '{{WRAPPER}} .gsc-icon-box-group .icon-box-item-content .title, {{WRAPPER}} .gsc-icon-box-group .icon-box-item-content .title a',
		 	]
	  	);

	  	$this->add_control(
		 	'heading_description',
		 	[
				'label' => __( 'Description', 'homirx-themer' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
				  'style' => ['style-2'],
				]
		 	]
	  	);

	  	$this->add_control(
		 	'description_color',
		 	[
				'label' => __( 'Color', 'homirx-themer' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
				  '{{WRAPPER}} .gsc-icon-box-group .icon-box-item-content .desc' => 'color: {{VALUE}};',
				],
				'condition' => [
				  'style' => ['style-2']
				]
		 	]
	  	);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'description_typography',
				'selector' => '{{WRAPPER}} .gsc-icon-box-group .icon-box-item-content',
				'condition' => [
				  'style' => ['style-2'],
				],
			]
		);

		$this->end_controls_section();
	}


	protected function render() {
		$settings = $this->get_settings_for_display();
		printf( '<div class="gva-element-%s gva-element">', $this->get_name() );
			if( !empty($settings['layout']) ){
				include $this->get_template(self::TEMPLATE . $settings['layout'] . '.php');
			}
		print '</div>';
	}

}

$widgets_manager->register(new GVAElement_Listings_Banner_Group());
