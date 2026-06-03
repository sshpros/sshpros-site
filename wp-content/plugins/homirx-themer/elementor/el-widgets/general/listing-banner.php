<?php

if (!defined('ABSPATH')) {
	 exit; // Exit if accessed directly.
}

use Elementor\Controls_Manager;
use Elementor\Utils;
use Elementor\Scheme_Color;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Image_Size;

class GVAElement_Listing_Banner extends GVAElement_Base{
	
	const NAME = 'gva_listing_banner';
	const TEMPLATE = 'general/banner';
	const CATEGORY = 'homirx_listing';

	public function get_categories() {
		return array(self::CATEGORY);
	}

	public function get_name() {
		return self::NAME;
	}

	public function get_title() {
		return esc_html__('Listing Banner', 'homirx-themer');
	}

	public function get_keywords() {
		return [ 'listing', 'banner' ];
	}

	public function get_script_depends() {
		return array();
	}

	public function get_style_depends() {
		return array();
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
				'label'     => __('Style', 'homirx-themer'),
				'type'      => \Elementor\Controls_Manager::SELECT,
				'default' => 'style-1',
				'options' => [
					'style-1'      => __('Style 01', 'homirx-themer')
				],
			]
	  	);

		$this->add_control(
			'title',
			[
				'label' => __('Title', 'homirx-themer'),
				'type' => Controls_Manager::TEXT,
				'label_block'	=> true,
				'placeholder' => esc_html__('Add your Title', 'homirx-themer'),
				'default' => esc_html__('Switzerland', 'homirx-themer')
			]
		);

		$this->add_control(
			'desc',
			[
				'label' => __('Description', 'homirx-themer'),
				'type' => Controls_Manager::TEXTAREA,
				'placeholder' => esc_html__('Add your Description', 'homirx-themer'),
				'default' => esc_html__('Venezia, Italy', 'homirx-themer')
			]
		);

		if(class_exists('ATBDP_Listing')){
			$this->add_control(
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
			$this->add_control(
				'term_slug',
				[
					'label'       	=> esc_html__('Term Slug', 'homirx-themer'),
					'type'        	=> Controls_Manager::TEXT,
					'placeholder'	=> esc_html__('ex: villa', 'homirx-themer'),
					'default'	  	=> ''
				]
			);
		}
		$this->add_control(
			'image',
			[
				'label' 		=> __('Image', 'homirx-themer'),
				'type' 		=> Controls_Manager::TEXT,
				'default'    => [
					 'url' => GAVIAS_HOMIRX_PLUGIN_URL . 'elementor/assets/images/image-banner.jpg',
				],
				'type'       => Controls_Manager::MEDIA,
				'show_label' => false,
			]
		);

		$this->add_responsive_control(
			'height',
			[
				'label' => __('Height', 'homirx-themer'),
				'type' => Controls_Manager::SLIDER,
				'range' => [
				  'px' => [
					 'min' => 100,
					 'max' => 1000,
				  ],
				],
				'default' => [
				  'size'  => 270
				],
				'condition' => [
				  'style' => ['style-1']
				],
				'selectors' => [
				  '{{WRAPPER}} .banner-one__wrap' => 'min-height: {{SIZE}}{{UNIT}};',
				  '{{WRAPPER}} .banner-two__wrap' => 'min-height: {{SIZE}}{{UNIT}};',
				],
			]
		); 

		$this->add_control(
			'link',
			[
				'label' => __('Link', 'homirx-themer'),
				'type' => Controls_Manager::URL,
				'label_block'	=> true,
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
		$this->add_control(
			'bg_overlay',
			[
				'label' => __('Overlay Background', 'homirx-themer'),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
				  '{{WRAPPER}} .banner-one__image:after' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'show_number_content',
			[
				'label'   => __('Show number content', 'homirx-themer'),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'no'
			]
		 );
		$this->add_control(
			'show_number_text',
			[
				'label'   => __('Text Prefix', 'homirx-themer'),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__('listings', 'homirx-themer'),
				'condition' => [
				  'show_number_content' => ['yes']
				],
			]
		 );
		$this->add_control(
			'show_number_one_text',
			[
				'label'   => __('Text Prefix One Item', 'homirx-themer'),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__('listing', 'homirx-themer'),
				'condition' => [
				  'show_number_content' => ['yes']
				],
			]
		 );
		$this->add_control(
			'item_active',
			[
				'label'   => __('Active', 'homirx-themer'),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'no'
			]
		 );
		$this->end_controls_section();


		$this->start_controls_section(
			'section_style_content',
			[
				'label' => __('Content', 'homirx-themer'),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'heading_title',
			[
				'label' => __('Title', 'homirx-themer'),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		  $this->add_control(
			 'title_color',
			 [
				'label' => __('Color', 'homirx-themer'),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
				  '{{WRAPPER}} .banner-one__title' => 'color: {{VALUE}};',
				  '{{WRAPPER}} .banner-two__title' => 'color: {{VALUE}};',
				],
			 ]
		  );

		  $this->add_group_control(
			 Group_Control_Typography::get_type(),
			 [
				'name' => 'title_typography',
				'selector' => '{{WRAPPER}} .banner-one__title, {{WRAPPER}} .banner-two__title',
			 ]
		  );

		  	$this->add_control(
			'heading_desc',
			[
				'label' => __('Description', 'homirx-themer'),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		  $this->add_control(
			 'desc_color',
			 [
				'label' => __('Color', 'homirx-themer'),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
				  '{{WRAPPER}} .banner-one__desc' => 'color: {{VALUE}};',
				  '{{WRAPPER}} .banner-two__desc' => 'color: {{VALUE}};',
				],
			 ]
		  );

		  $this->add_group_control(
			 Group_Control_Typography::get_type(),
			 [
				'name' => 'desctypography',
				'selector' => '{{WRAPPER}} .banner-one__desc, {{WRAPPER}} .banner-two__desc',
			 ]
		  );


		  $this->end_controls_section();
	 }

	 protected function render() {
		$settings = $this->get_settings_for_display();
		printf('<div class="gva-element-%s gva-element">', $this->get_name() );
			include $this->get_template( self::TEMPLATE . '.php');
		print '</div>';
	 }

}

$widgets_manager->register(new GVAElement_Listing_Banner());
