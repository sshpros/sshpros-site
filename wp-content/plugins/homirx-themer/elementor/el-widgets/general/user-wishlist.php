<?php
if(!defined('ABSPATH')){ exit; }
use Elementor\Controls_Manager;
use Elementor\Scheme_Color;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Typography;

class GVAElement_User_Wishlist extends GVAElement_Base {
   
   const NAME = 'gva-user-wishlist';
   const TEMPLATE = 'general/user-wishlist';
   const CATEGORY = 'homirx_general';

	public function get_name() {
      return self::NAME;
    }

	public function get_categories() {
      return array(self::CATEGORY);
   }

	public function get_title() {
		return __( 'GVA User Wishlist', 'homirx-themer' );
	}

	public function get_keywords() {
		return [ 'user', 'block', 'wishlist' ];
	}

	protected function register_controls() {

		$this->start_controls_section(
			'section_content',
			[
				'label' => __( 'Content', 'homirx-themer' ),
			]
		);
      $this->add_control(
         'align',
         [
            'label' => __( 'Alignment', 'homirx-themer' ),
            'type' => Controls_Manager::CHOOSE,
            'options' => [
               'left' => [
                  'title' => __( 'Left', 'homirx-themer' ),
                  'icon' => 'fa fa-align-left',
               ],
               'center' => [
                  'title' => __( 'Center', 'homirx-themer' ),
                  'icon' => 'fa fa-align-center',
               ],
               'right' => [
                  'title' => __( 'Right', 'homirx-themer' ),
                  'icon' => 'fa fa-align-right',
               ],
            ],
            'default' => 'center',
         ]
      );

      $this->add_control(
         'wishlist_text',
         [
            'label'        => __( 'Wishlist Text', 'homirx-themer' ),
            'type'         => Controls_Manager::TEXT,
            'default'      => 'Wishlist',
            'label_block'  => true
         ]
      );

      $this->add_control(
         'link',
         [
            'label' => __( 'Wishlist Link', 'homirx-themer' ),
            'type' => Controls_Manager::URL,
            'placeholder' => __( 'https://your-link.com', 'homirx-themer' ),
         ]
      );

      $this->add_control(
         'selected_icon',
         [
            'label' => __( 'Icon', 'homirx-themer' ),
            'type' => Controls_Manager::ICONS,
            'fa4compatibility' => 'icon',
            'default' => [
               'value' => 'fas fa-heart',
               'library' => 'fa-solid',
            ],
         ]
      );
		
		$this->end_controls_section();

      $this->start_controls_section(
         'section_content_style',
         [
            'label' => __( 'Text & Icon', 'homirx-themer' ),
            'tab' => Controls_Manager::TAB_STYLE,
         ]
      );

      $this->add_control(
         'icon_style',
         [
            'label' => __( 'Icon Style', 'homirx-themer' ),
            'type'      => Controls_Manager::HEADING,
         ]
      );

      $this->add_responsive_control(
         'icon_size',
         [
            'label' => __( 'Icon Size', 'homirx-themer' ),
            'type' => Controls_Manager::SLIDER,
            'default' => [
               'size' => 16,
            ],
            'range' => [
               'px' => [
                  'min' => 0,
                  'max' => 100,
               ],
            ],
            'selectors' => [
               '{{WRAPPER}} .user-wishlist .wishlist-icon i' => 'font-size: {{SIZE}}{{UNIT}};',
               '{{WRAPPER}} .user-wishlist .wishlist-icon svg' => 'width: {{SIZE}}{{UNIT}};',
            ],
         ]
      );

      $this->add_control(
         'icon_color',
         [
            'label' => __( 'Color', 'homirx-themer' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
               '{{WRAPPER}} .user-wishlist .wishlist-icon i' => 'color: {{VALUE}}', 
               '{{WRAPPER}} .user-wishlist .wishlist-icon svg' => 'fill: {{VALUE}}', 
            ],
         ]
      );

      $this->add_control(
         'icon_color_hover',
         [
            'label' => __( 'Color Hover', 'homirx-themer' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
               '{{WRAPPER}} .user-wishlist .wishlist-link:hover .wishlist-icon i' => 'color: {{VALUE}}!important', 
               '{{WRAPPER}} .user-wishlist .wishlist-link:hover .wishlist-icon svg' => 'fill: {{VALUE}}!important', 
            ],
         ]
      );

      $this->add_control(
         'text_style',
         [
            'label' => __( 'Text Style', 'homirx-themer' ),
            'type'      => Controls_Manager::HEADING,
         ]
      );

      $this->add_control(
         'text_color',
         [
            'label' => __( 'Text Color', 'homirx-themer' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
               '{{WRAPPER}} .user-wishlist .wishlist-link' => 'color: {{VALUE}}', 
            ],
         ]
      );

      $this->add_control(
         'text_color_hover',
         [
            'label' => __( 'Text Color Hover', 'homirx-themer' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
               '{{WRAPPER}} .user-wishlist .wishlist-link:hover' => 'color: {{VALUE}}', 
            ],
         ]
      );

      $this->add_group_control(
         Group_Control_Typography::get_type(),
         [
            'name' => 'text_typography',
            'selector' => '{{WRAPPER}} .user-wishlist .wishlist-link',
         ]
      );

      $this->end_controls_section();

      $this->end_controls_tab();

      $this->end_controls_tabs();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		printf( '<div class="gva-element-%s gva-element">', $this->get_name() );
        include $this->get_template(self::TEMPLATE . '.php');
      print '</div>';
	}
}

$widgets_manager->register(new GVAElement_User_Wishlist());
