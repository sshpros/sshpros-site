<?php
if(!defined('ABSPATH')){ exit; }
use Elementor\Controls_Manager;
use Elementor\Scheme_Color;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Image_Size;

class GVAElement_Counter extends GVAElement_Base {  

	const NAME = 'gva-counter';
   const TEMPLATE = 'general/counter';
   const CATEGORY = 'homirx_general';

   public function get_name() {
      return self::NAME;
   }

   public function get_categories() {
      return array(self::CATEGORY);
   }
   
	public function get_title() {
		return __( 'Counter', 'homirx-themer' );
	}

	
	public function get_keywords() {
		return [ 'counter', 'icon' ];
	}

	public function get_script_depends() {
      return [
         'jquery.count_to',
         'jquery.appear',
      ];
   }

	protected function register_controls() {
		$this->start_controls_section(
			'section_content',
			[
				'label' => __( 'Content', 'homirx-themer' ),
			]
		);
		$this->add_control(
			'style',
			[
				'label' => __( 'Style', 'homirx-themer' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'style-1' 		=> __( 'Style 01', 'homirx-themer' ),
					'style-2' 		=> __( 'Style 02', 'homirx-themer' ),
					'style-3' 		=> __( 'Style 03', 'homirx-themer' )
				],
				'default' => 'style-1',
			]
		);
		$this->add_control(
			'selected_icon',
			[
				'label' => __( 'Icon Class', 'homirx-themer' ),
				'type' => Controls_Manager::ICONS,
				'fa4compatibility' => 'icon',
				'default' => [
					'value' => 'fas fa-home',
					'library' => 'fa-solid',
				],
				'condition' => [
					'style' => ['style-2', 'style-3'],
				]
			]
		);
		$this->add_control(
			'number',
			[
				'label' => __( 'Number', 'homirx-themer' ),
				'type' => Controls_Manager::NUMBER,
				'default' => 110
			]
		);
		$this->add_control(
			'text_before',
			[
				'label' => __( 'Text Before Number', 'homirx-themer' ),
				'type' => Controls_Manager::TEXT,
			]
		);
		$this->add_control(
			'text_after',
			[
				'label' => __( 'Text After Number', 'homirx-themer' ),
				'type' => Controls_Manager::TEXT,
			]
		);
		$this->add_control(
			'title_text',
			[
				'label' => __( 'Title', 'homirx-themer' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'This is the heading', 'homirx-themer' ),
				'placeholder' => __( 'Enter your title', 'homirx-themer' ),
				'label_block' => true,
			]
		);
		$this->add_control(
			'desc_text',
			[
				'label' => __( 'Description', 'homirx-themer' ),
				'type' => Controls_Manager::TEXTAREA,
				'default' => __( 'Lorem ipsum is simply free text available.', 'homirx-themer' ),
				'placeholder' => __( 'Enter your description', 'homirx-themer' ),
				'label_block' => true,
				'condition' => [
					'style' => ['style-2'],
				]
			]
		);
		$this->add_control(
			'link',
			[
				'label' => __( 'Link', 'homirx-themer' ),
				'type' => Controls_Manager::URL,
				'placeholder' => __( 'https://your-link.com', 'homirx-themer' ),
			]
		);
		$this->add_control(
			'title_size',
			[
				'label' => __( 'Title HTML Tag', 'homirx-themer' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'h1' => 'H1',
					'h2' => 'H2',
					'h3' => 'H3',
					'h4' => 'H4',
					'h5' => 'H5',
					'h6' => 'H6',
					'div' => 'div',
					'span' => 'span',
					'p' => 'p',
				],
				'default' => 'div',
			]
		);
		
		$this->end_controls_section();
		// Style box
		$this->start_controls_section(
			'section_style_box',
			[
				'label' => __( 'Box Icon', 'homirx-themer' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition' => [
					'style' => ['style-1'],
				]
			]
		);

		$this->add_control(
			'box_border_color',
			[
				'label' => __( 'Box Border Color', 'homirx-themer' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .milestone-one__single:before' => 'border-color: {{VALUE}};',
				],
				'condition' => [
					'style' => ['style-1'],
				]
			]
		);

		$this->end_controls_section();

		// Style Icon
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
					'{{WRAPPER}} .milestone-one__icon i, {{WRAPPER}} .milestone-two__icon i' => 'color: {{VALUE}};',
					'{{WRAPPER}} .milestone-one__icon svg, {{WRAPPER}} .milestone-two__icon svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'icon_size',
			[
				'label' => __( 'Icon Size', 'homirx-themer' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 6,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .milestone-one__icon i, {{WRAPPER}} .milestone-two__icon i' => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .milestone-one__icon svg, {{WRAPPER}} .milestone-two__icon svg' => 'width: {{SIZE}}{{UNIT}};'
				],
			]
		);

		$this->add_responsive_control(
			'icon_space',
			[
				'label' => __( 'Spacing', 'homirx-themer' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .milestone-one__icon, {{WRAPPER}} .milestone-two__icon' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		// Title
		$this->start_controls_section(
			'section_title_style',
			[
				'label' => __( 'Title', 'homirx-themer' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'title_top_space',
			[
				'label' => __( 'Spacing', 'homirx-themer' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .milestone-one__title, {{WRAPPER}} .milestone-two__title' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				'selector' => '{{WRAPPER}} .milestone-one__title, {{WRAPPER}} .milestone-two__title',
			]
		);

		$this->add_control(
			'title_color',
			[
				'label' => __( 'Color', 'homirx-themer' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .milestone-one__title, {{WRAPPER}} .milestone-two__title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'title_bg_color',
			[
				'label' => __( 'Background Color', 'homirx-themer' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .milestone-one__title' => 'background: {{VALUE}};',
					'{{WRAPPER}} .milestone-one__title:after'	=> 'border-bottom-color: {{VALUE}};'
				],
				'condition' => [
					'style' => ['style-1']
				],
			]
		);
		
		$this->add_control(
			'title_hover',
			[
				'label' => __( 'Hover - Color', 'homirx-themer' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .milestone-one__single:hover .milestone-one__title, {{WRAPPER}} .milestone-one__single:focus .milestone-one__title' => 'color: {{VALUE}};',
				],
				'condition' => [
					'style' => ['style-1']
				],
			]
		);

		$this->add_control(
			'title_hover_bg',
			[
				'label' => __( 'Hover - Background Color', 'homirx-themer' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .milestone-one__single:hover .milestone-one__title, {{WRAPPER}} .milestone-one__single:focus .milestone-one__title' => 'background: {{VALUE}};',
					'{{WRAPPER}} .milestone-one__single:hover .milestone-one__title:after, {{WRAPPER}} .milestone-one__single:focus .milestone-one__title:after' => 'border-bottom-color: {{VALUE}};',
				],
				'condition' => [
					'style' => ['style-1']
				],
			]
		);
		$this->end_controls_section();

		// Number Text
		$this->start_controls_section(
			'sectionn_number_style',
			[
				'label' => __( 'Number Text', 'homirx-themer' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'number_bottom_space',
			[
				'label' => __( 'Spacing', 'homirx-themer' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .milestone-one__number, {{WRAPPER}} .milestone-two__number' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'number_text_color',
			[
				'label' => __( 'Color', 'homirx-themer' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .milestone-one__number, {{WRAPPER}} .milestone-two__number' => 'color: {{VALUE}};',
					'{{WRAPPER}} .milestone-one__number .symbol, {{WRAPPER}} .milestone-two__number .symbol' => 'color: {{VALUE}};',
				]
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'number_text_typography',
				'selector' => '{{WRAPPER}} .milestone-one__number, {{WRAPPER}} .milestone-two__number',
			]
		);

		$this->end_controls_section();

		// Description
		$this->start_controls_section(
			'section_desc_style',
			[
				'label' => __( 'Description', 'homirx-themer' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition' => [
					'style' => ['style-2']
				]
			]
		);
		$this->add_responsive_control(
			'desc_top_space',
			[
				'label' => __( 'Spacing', 'homirx-themer' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .milestone-two__desc' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_control(
			'desc_color',
			[
				'label' => __( 'Color', 'homirx-themer' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .milestone-two__desc' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'desc_typography',
				'selector' => '{{WRAPPER}} .milestone-two__desc',
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
$widgets_manager->register(new GVAElement_Counter());
