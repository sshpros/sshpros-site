<?php
if(!defined('ABSPATH')){ exit; }

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Image_Size;
use Elementor\Repeater;

class GVAElement_Slider_Property extends GVAElement_Base{
  	const NAME = 'gva-slider-property';
  	const TEMPLATE = 'general/slider-property';
  	const CATEGORY = 'homirx_general';

  	public function get_name() {
	 	return self::NAME;
  	}

  	public function get_categories() {
	 	return array(self::CATEGORY);
  	}

  	public function get_title() {
	 	return __('Slider Property', 'homirx-themer');
  	}

  	public function get_keywords() {
	 	return [ 'slider', 'content', 'property' ];
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
  
		$repeater = new Repeater();

		$repeater->add_control(
			'style',
			[
				'label' => __( 'Style', 'homirx-themer' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'style-1' 		=> __( 'Style 01', 'homirx-themer' ),
					'style-2' 		=> __( 'Style 02', 'homirx-themer' )
				],
				'default' => 'style-1',
			]
		);
	  	$repeater->add_control(
			'image',
			[
				 'label'      => __('Choose Image Background', 'homirx-themer'),
				 'default'    => [
					  'url' => GAVIAS_HOMIRX_PLUGIN_URL . 'elementor/assets/images/slider-1.jpg',
				 ],
				 'type'       => Controls_Manager::MEDIA,
				 'show_label' => true
			]
	  	);
	  	$repeater->add_control(
			'heading_btn',
			[
				'label'       => __('----- Property Content -----', 'homirx-themer'),
				'type'        => Controls_Manager::HEADING,
			]
		);
	  	$repeater->add_control(
		 	'sub_title',
		 	[
				'label'       => __('SubTitle', 'homirx-themer'),
				'type'        => Controls_Manager::TEXT,
				'default'     => 'Premium',
				'label_block' => true,
			]
	  	);
		$repeater->add_control(
			'title',
			[
				'label'       => __('Title', 'homirx-themer'),
				'type'        => Controls_Manager::TEXT,
				'default'     => 'Add your Title',
				'label_block' => true,
			]
		);
	  	$repeater->add_control(
		 	'location',
		 	[
				'label'       => __('Location', 'homirx-themer'),
				'type'        => Controls_Manager::TEXT,
				'default'     => 'New.Mexico',
				'label_block' => true,
		 	]
	  	);
	  	$repeater->add_control(
			'info',
			[
				'label'       => __('Information', 'homirx-themer'),
				'type'        => Controls_Manager::CODE ,
				'default'     => '<span><i class="hicon-maximize"></i>150m</span><span><i class="hicon-bed"></i>Bed 3</span><span><i class="hicon-bath-tub"></i>Bath 3</span>',
			]
		);
		$repeater->add_control(
			'price',
			[
				'label'       => __('Price', 'homirx-themer'),
				'type'        => Controls_Manager::TEXT,
				'default'     => '$456.00',
			]
		);
		$repeater->add_control(
			 'btn_title',
			 [
				'label'       => __('Button Title', 'homirx-themer'),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__('View Details', 'homirx-themer'),
				'label_block' => true,
			 ]
		);
		$repeater->add_control(
			'btn_link',
			[
				'label'     => __( 'Button Link', 'homirx-themer' ),
				'type'      => Controls_Manager::URL,
				'placeholder' => __( 'https://your-link.com', 'homirx-themer' ),
				'label_block' => true
			]
		);
		$repeater->add_control(
			'other_content',
			[
				'label'       => __('----- Other Content -----', 'homirx-themer'),
				'type'        => Controls_Manager::HEADING,
			]
		);
		$repeater->add_control(
			'image_second',
			[
				 'label'      => __('Choose Image Second', 'homirx-themer'),
				 'default'    => [
					  'url' => GAVIAS_HOMIRX_PLUGIN_URL . 'elementor/assets/images/gallery-1.jpg',
				 ],
				 'type'       => Controls_Manager::MEDIA,
				 'show_label' => true
			]
	  	);
		$repeater->add_control(
			'custom_html',
			[
				'label'     => __( 'HTML Custom', 'homirx-themer' ),
				'type'      => Controls_Manager::CODE,
				'label_block' => true
			]
		 );

		$this->add_control(
			'carousel_content',
			[
				'label'       => __('Content Item', 'homirx-themer'),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'title_field' => '{{{ title }}}',
				'default'     => array(
					array(
						'sub_title'         => esc_html__( 'Premium', 'homirx-themer' ),
						'title'             => 'Luxury Home'
					),
					array(
						'sub_title'         => esc_html__( 'Premium', 'homirx-themer' ),
						'title'             => 'Luxury Home'
					),
				) 
			]
		);
		  
		$this->end_controls_section();

		// Slider Setting ---------------
		$this->start_controls_section(
			'section_slider_setting',
			[
				'label' => __( 'Sliders Setting', 'homirx-themer' )
			]
		);
		$this->add_control(
			'style',
			[
				'label' => __( 'Style', 'homirx-themer' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'wrap-1' 		=> __( 'Style 01', 'homirx-themer' ),
					'wrap-2' 		=> __( 'Style 02', 'homirx-themer' )
				],
				'default' => 'wrap-1',
			]
		);
		$this->add_responsive_control(
			'min_height',
			[
				'label' 		=> esc_html__('Min Height', 'homirx-themer'),
				'type' 		=> Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 100,
						'max' => 1500,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .slider-property .swiper-slide' => 'min-height: {{SIZE}}{{UNIT}};',
					
				],
			]
		);
		$this->add_responsive_control(
			'content_padding_top',
			[
				'label' 		=> esc_html__('Content Padding Top', 'homirx-themer'),
				'type' 		=> Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1500,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .slider-property .swiper-slide .slider-content' => 'padding-top: {{SIZE}}{{UNIT}};',
					
				],
			]
		);
		$this->add_control(
			'space_between',
			[
			  'label'     => __('Space Between Items', 'homirx-themer'),
			  'type'      => Controls_Manager::NUMBER,
				'default'	=> 0
			]
	 	);
	  	$this->add_control(
			'ca_loop',
			[
				'label'     => __('Loop', 'homirx-themer'),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => 'yes'
			]
		);
		$this->add_control(
			'ca_speed',
			[
				'label'     => __('Speed', 'homirx-themer'),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 1200,
			]
		);
		$this->add_control(
			'ca_autoplay',
			[
				'label'     => __('Auto Play', 'homirx-themer'),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => 'yes'
			]
		 );
		$this->add_control(
			'ca_autoplay_delay',
			[
				'label'     => __('Auto Play Delay', 'homirx-themer'),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 5000,
			]
		);
		$this->add_control(
			'ca_autoplay_hover',
			[
				'label'     => __('Play Hover', 'homirx-themer'),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => 'yes'
			]
		);
		$this->add_control(
			'ca_navigation',
			[
				'label'     => __('Navigation', 'homirx-themer'),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => 'yes'
			]
		);
		$this->add_control(
			'ca_pagination',
			[
				'label'     => __('Pagination', 'homirx-themer'),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => 'no'
			]
		);
		$this->end_controls_section();

		// Style -----------------
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
				  'size'  => 0
				],
				'selectors' => [
				  '{{WRAPPER}} .gsc-content-carousel .item-content .item-content-inner .box-content .gsc-heading .title' => 'padding-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		); 

		  $this->end_controls_section();
	 }

	 protected function render() {
		$settings = $this->get_settings_for_display();
		printf( '<div class="gva-element-%s gva-element">', $this->get_name() );
		include $this->get_template(self::TEMPLATE . '.php');
		print '</div>';
	 }

}

$widgets_manager->register(new GVAElement_Slider_Property());
