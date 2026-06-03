<?php
if(!defined('ABSPATH')){ exit; }

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Image_Size;
use Elementor\Repeater;

class GVAElement_Location_Image extends GVAElement_Base{
  	const NAME = 'gva-location-image';
  	const TEMPLATE = 'general/location-image/';
  	const CATEGORY = 'homirx_general';

  	public function get_name() {
	 	return self::NAME;
  	}

  	public function get_categories() {
	 	return array(self::CATEGORY);
  	}

	public function get_title() {
		return esc_html__('Location Image', 'homirx-themer');
	}

	public function get_keywords() {
		return [ 'location', 'locations', 'content' ];
	}

	public function get_script_depends() {
		return [
			'gavias.elements',
		];
	}

	public function get_style_depends() {
		return array();
	}

	protected function register_controls() {
		$this->start_controls_section(
			'section_content',
			[
				'label' => esc_html__('Content', 'homirx-themer'),
			]
		);
		$this->add_control( // xx Layout
			'layout_heading',
			[
				'label'   => esc_html__('Layout', 'homirx-themer'),
				'type'    => Controls_Manager::HEADING,
			]
		);
		$this->add_control(
			'title_text',
			[
				'label'       => esc_html__('Title', 'homirx-themer'),
				'type'        => Controls_Manager::TEXT,
				'default'     => 'Add your Title',
				'label_block' => true,
			]
		);
		$this->add_control(
			'layout',
			[
				'label'   => esc_html__('Layout Display', 'homirx-themer'),
				'type'    => Controls_Manager::SELECT,
				'default' => 'layout-1',
				'options' => [
					'layout-1'      => esc_html__('Layout 01', 'homirx-themer'),
				]
			]
	  	);
	  	$this->add_control(
			'image',
			[
				'label'      => esc_html__('Choose Image', 'homirx-themer'),
				'default'    => [
					'url' => GAVIAS_HOMIRX_PLUGIN_URL . 'elementor/assets/images/location-image.png',
				],
				'type'       => Controls_Manager::MEDIA,
				'show_label' => false,
			]
		);
		$repeater = new Repeater();
		$repeater->add_control(
			'title',
			[
				'label'       => esc_html__('Title', 'homirx-themer'),
				'type'        => Controls_Manager::TEXT,
				'default'     => 'Add your Title',
				'label_block' => true,
			]
		);
		$repeater->add_control(
			'address',
			[
				'label'       => esc_html__('Address', 'homirx-themer'),
				'type'        => Controls_Manager::TEXTAREA,
				'default'     => '6391 Elgin St. Celina.',
				'label_block' => true,
			]
		);
		$repeater->add_control(
			'post_code',
			[
				'label'       => esc_html__('Post Code', 'homirx-themer'),
				'type'        => Controls_Manager::TEXT,
				'default'     => '14235',
				'label_block' => true,
			]
		);
		$repeater->add_control(
			'image',
			[
				'label'      => esc_html__('Choose Image', 'homirx-themer'),
				'default'    => [
					'url' => GAVIAS_HOMIRX_PLUGIN_URL . 'elementor/assets/images/banner-1.jpg',
				],
				'type'       => Controls_Manager::MEDIA,
				'show_label' => false,
			]
		);
		$repeater->add_control(
			'left',
			[
				'label'     	=> esc_html__('Left', 'homirx-themer'),
				'type'      	=> Controls_Manager::SLIDER,
				'size_units' 	=> '%',
				'range' => [
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => '%',
					'size' => 10,
				],
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}}' => 'left: {{SIZE}}{{UNIT}};',
				]
			]
		);
		$repeater->add_control(
			'top',
			[
				'label'     => esc_html__('Top', 'homirx-themer'),
				'type'      => Controls_Manager::SLIDER,
				'size_units' 	=> '%',
				'range' => [
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => '%',
					'size' => 10,
				],
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}}' => 'top: {{SIZE}}{{UNIT}};',
				]
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
			'active',
			[
				'label' => __( 'Active', 'homirx-themer' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'no'
			]
		);
		$this->add_control(
			'location_content',
			[
				'label'       => esc_html__('Content Item', 'homirx-themer'),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'title_field' => '{{{ title }}}',
				'default'     => array(
				  	array(
					 	'title'  => esc_html__('Singapore Office', 'homirx-themer'),
					 	'left'	=> array('unit' => '%','size' => 16),
					 	'top'		=> array('unit' => '%','size' => 25),
				  	),
				  	array(
					 	'title'  => esc_html__('Paris Office', 'homirx-themer'),
					 	'left'	=> array('unit' => '%','size' => 40),
					 	'top'		=> array('unit' => '%','size' => 80),
				  	),
				  	array(
					 	'title'  => esc_html__('New York Office', 'homirx-themer'),
					 	'left'	=> array('unit' => '%','size' => 73),
					 	'top'		=> array('unit' => '%','size' => 22),
				  	),
				  	array(
					 	'title'  => esc_html__('London Office', 'homirx-themer'),
					 	'left'	=> array('unit' => '%','size' => 75),
					 	'top'		=> array('unit' => '%','size' => 65),
				  	),
				  	array(
					 	'title'  => esc_html__('Canada Office', 'homirx-themer'),
					 	'left'	=> array('unit' => '%','size' => 13),
					 	'top'		=> array('unit' => '%','size' => 51),
				  	)
				)
			]
		);

		$this->end_controls_section();

		// Icon Styling
		$this->start_controls_section(
			'section_style',
			[
				'label' => esc_html__('Style', 'homirx-themer'),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->end_controls_section();

	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		printf('<div class="gva-element-%s gva-element">', $this->get_name() );
		if( !empty($settings['layout']) ){
			include $this->get_template(self::TEMPLATE . $settings['layout'] . '.php');
		}
		print '</div>';
	}
}

$widgets_manager->register(new GVAElement_Location_Image());
