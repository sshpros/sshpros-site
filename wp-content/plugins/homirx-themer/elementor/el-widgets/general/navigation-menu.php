<?php
if(!defined('ABSPATH')){ exit; }

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Image_Size;

class GVAElement_Navigation_Menu extends GVAElement_Base {
	const NAME = 'gva-navigation-menu';
   const TEMPLATE = 'general/navigation-menu';
   const CATEGORY = 'homirx_general';

	public function get_name() {
      return self::NAME;
   }

   public function get_categories() {
      return array(self::CATEGORY);
   }

	public function get_title() {
		return __( 'Navigation Menu', 'homirx-themer' );
	}

	public function get_keywords() {
		return [ 'menu', 'navigation' ];
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
			'menu',
			[
				'label' 			=> __( 'Menu', 'homirx-themer' ),
				'type' 			=> Controls_Manager::SELECT,
				'options' 		=> $this->get_all_menus(),
				'label_block' 	=> true,
				'default'		=> 'main-menu'
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
			'sub_menu_min_width',
			[
				'label' => __( 'Submenu Min Width (px)', 'homirx-themer' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 260,
				],
				'range' => [
					'px' => [
						'min' => 100,
						'max' => 500,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .gva-navigation-menu ul.gva-nav-menu > li .submenu-inner, .gva-navigation-menu ul.gva-nav-menu > li ul.submenu-inner' => 'min-width: {{SIZE}}{{UNIT}};',
				],
			]
		);
	
		$this->end_controls_section();

		//Styling Main Menu
		$this->start_controls_section(
			'section_main_menu_style',
			[
				'label' => __( 'Main Menu', 'homirx-themer' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);


		//Tabs Styling Normal, Hover, Active
		$this->start_controls_tabs('tabs_main_menu_style');

		$this->start_controls_tab(
			'main_menu_style_normal',
			[
				'label' => __('Normal', 'homirx-themer'),
			]
		);
		$this->add_control(
			'main_menu_text_color',
			[
				'label'     => __('Text Color', 'homirx-themer'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .gva-navigation-menu ul.gva-nav-menu > li' => 'color: {{VALUE}}', 
				],
			]
		);
		$this->add_control(
			'main_menu_color',
			[
				'label'     => __('Color', 'homirx-themer'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					 '{{WRAPPER}} .gva-navigation-menu ul.gva-nav-menu > li > a' => 'color: {{VALUE}}',
				],
			]
		);
		$this->end_controls_tab();

		$this->start_controls_tab(
			'main_menu_hover',
			[
				'label' => __('Hover', 'homirx-themer'),
			]
		);
		$this->add_control(
			'main_menu_hover_color',
			[
				'label'     => __('Color', 'homirx-themer'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .gva-navigation-menu ul.gva-nav-menu > li > a:hover, {{WRAPPER}} ul.gva-nav-menu > li:hover > a, {{WRAPPER}} li.current-menu-item > a' => 'color: {{VALUE}}!important', 
				],
			]
		);
		$this->end_controls_tab();

		$this->start_controls_tab(
			'main_menu_active',
			[
				'label' => __('Active', 'homirx-themer'),
			]
		);
		$this->add_control(
			'main_menu_active_color',
			[
				'label'     => __('Color', 'homirx-themer'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .gva-navigation-menu ul.gva-nav-menu > li.current_page_parent > a' => 'color: {{VALUE}}', 
				],
			]
		);
		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'menu_top_line_color',
			[
				'label'     => __('Top Line Color', 'homirx-themer'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} ul.gva-nav-menu > li > a .menu-title:after' => 'background-color: {{VALUE}}', 
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'typography',
				'selector' => '{{WRAPPER}} .gva-navigation-menu ul.gva-nav-menu > li > a',
			]
		);

		$this->add_responsive_control(
			'main_menu_padding',
			[
				'label' => __( 'Menu Item Padding', 'homirx-themer' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .gva-navigation-menu ul.gva-nav-menu > li' => 'padding: 0 {{RIGHT}}{{UNIT}} 0 {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .gva-navigation-menu ul.gva-nav-menu > li > a' => 'padding: {{TOP}}{{UNIT}} 0 {{BOTTOM}}{{UNIT}} 0;',
				],
			]
		);

		$this->end_controls_section();

		//Styling Sub Menu
		$this->start_controls_section(
			'section_sub_menu_style',
			[
				'label' => __( 'Sub Menu', 'homirx-themer' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		//Tabs Styling Normal, Hover, Active
		$this->start_controls_tabs('tabs_sub_menu_style');

		$this->start_controls_tab(
			'sub_menu_style_normal',
			[
				'label' => __('Normal', 'homirx-themer'),
			]
		);
		$this->add_control(
			'sub_menu_text_color',
			[
				'label'     => __('Text Color', 'homirx-themer'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .gva-navigation-menu ul.gva-main-menu .submenu-inner' => 'color: {{VALUE}}', 
				],
			]
		);
		$this->add_control(
			'sub_menu_color',
			[
				'label'     => __('Color', 'homirx-themer'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					 '{{WRAPPER}} .gva-navigation-menu ul.gva-main-menu .submenu-inner a' => 'color: {{VALUE}}',
				],
			]
		);
		$this->end_controls_tab();

		$this->start_controls_tab(
			'sub_menu_hover',
			[
				'label' => __('Hover', 'homirx-themer'),
			]
		);
		
		$this->add_control(
			'sub_menu_hover_color',
			[
				'label'     => __('Link Color', 'homirx-themer'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .gva-navigation-menu ul.gva-main-menu .submenu-inner a:hover' => 'color: {{VALUE}}', 
					'{{WRAPPER}} .gva-navigation-menu ul.gva-main-menu .submenu-inner a:active' => 'color: {{VALUE}}', 
				],
			]
		);
		$this->end_controls_tab();

		$this->start_controls_tab(
			'sub_menu_active',
			[
				'label' => __('Active', 'homirx-themer'),
			]
		);
		$this->add_control(
			'sub_menu_active_color',
			[
				'label'     => __('Color', 'homirx-themer'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .gva-navigation-menu ul.gva-main-menu .submenu-inner li.current_page_parent a:hover' => 'color: {{VALUE}}', 
				],
			]
		);
		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'typography_2',
				'selector' => '{{WRAPPER}} .gva-navigation-menu ul.gva-main-menu .submenu-inner li a',
			]
		);

		$this->add_responsive_control(
			'sub_menu_padding',
			[
				'label' => __( 'Menu Item Padding', 'homirx-themer' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .gva-navigation-menu ul.gva-main-menu .submenu-inner li' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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

$widgets_manager->register(new GVAElement_Navigation_Menu());
