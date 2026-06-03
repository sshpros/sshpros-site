<?php
if(!defined('ABSPATH')){ exit; }

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Image_Size;

class GVAElement_Navigation_Mobile extends GVAElement_Base {
   const NAME = 'gva-navigation-mobile';
   const TEMPLATE = 'general/navigation-mobile';
   const CATEGORY = 'homirx_general';

   public function get_name() {
      return self::NAME;
   }

   public function get_categories() {
      return array(self::CATEGORY);
   }

   public function get_title() {
      return __( 'Navigation Mobile', 'homirx-themer' );
   }

   public function get_keywords() {
      return [ 'menu', 'navigation', 'mobile' ];
   }

   public function get_all_menus(){
      $menus = get_terms( 'nav_menu', array( 'hide_empty' => true ) ); 
      $results = array();
      foreach ($menus as $key => $menu) {
         $results[$menu->slug] = $menu->name;
      }
      return $results;
   }

   protected function register_controls() {
      $this->start_controls_section(
         'section_content',
         [
            'label' => __( 'Content', 'homirx-themer' ),
         ]
      );

      $this->add_control(
         'selected_icon',
         [
            'label' => __( 'Icon', 'homirx-themer' ),
            'type' => Controls_Manager::ICONS,
            'fa4compatibility' => 'icon',
            'default' => [
               'value' => 'fa-solid fa-bars',
               'library' => 'fa-solid',
            ],
         ]
      );

      $this->add_responsive_control(
         'icon_box_size',
         [
            'label' => __( 'Icon Box Size', 'homirx-themer' ),
            'type' => Controls_Manager::SLIDER,
            'default' => [
               'size' => 45,
            ],
            'range' => [
               'px' => [
                  'min' => 10,
                  'max' => 100,
               ],
            ],
            'selectors' => [
               '{{WRAPPER}} .gva-navigation-mobile .dropdown-toggle' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};',
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
               '{{WRAPPER}} .gva-navigation-mobile .dropdown-toggle' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
         ]
      );

      $this->add_control(
         'icon_color',
         [
            'label' => __( 'Primary Color', 'homirx-themer' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
               '{{WRAPPER}} .gva-navigation-mobile .dropdown-toggle i' => 'color: {{VALUE}}', 
               '{{WRAPPER}} .gva-navigation-mobile .dropdown-toggle svg' => 'fill: {{VALUE}}', 
            ],
         ]
      );

      $this->add_control(
         'icon_color_second',
         [
            'label' => __( 'Second Color', 'homirx-themer' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
               '{{WRAPPER}} .gva-navigation-mobile .dropdown-toggle' => 'border-color: {{VALUE}}', 
            ],
         ]
      );


      $this->add_control(
         'icon_color_hover',
         [
            'label' => __( 'Primary Color Hover', 'homirx-themer' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
               '{{WRAPPER}} .gva-navigation-mobile .dropdown-toggle:hover i' => 'color: {{VALUE}}', 
               '{{WRAPPER}} .gva-navigation-mobile .dropdown-toggle:hover svg' => 'fill: {{VALUE}}', 
            ],
         ]
      );

      $this->add_control(
         'icon_color_second_hover',
         [
            'label' => __( 'Second Color Hover', 'homirx-themer' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
               '{{WRAPPER}} .gva-navigation-mobile .dropdown-toggle:hover' => 'background: {{VALUE}}', 
               '{{WRAPPER}} .gva-navigation-mobile .dropdown-toggle:hover' => 'border-color: {{VALUE}}', 
            ],
         ]
      );

      $this->add_control(
         'border_radius',
         [
            'label' => __( 'Border Radius', 'homirx-themer' ),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', '%' ],
            'selectors' => [
               '{{WRAPPER}} .gva-navigation-mobile .dropdown-toggle' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
         ]
      );

      $this->end_controls_section();
   }

   protected function render(){

      parent::render();

      $settings = $this->get_settings_for_display();
      printf( '<div class="gva-element-%s gva-element">', $this->get_name() );
        include $this->get_template(self::TEMPLATE . '.php');
      print '</div>';
   }
}

$widgets_manager->register(new GVAElement_Navigation_Mobile());
