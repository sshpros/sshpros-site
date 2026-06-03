<?php
if(!defined('ABSPATH')){ exit; }

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Image_Size;

class GVAElement_User extends GVAElement_Base {
   
   const NAME = 'gva_user';
   const TEMPLATE = 'general/user';
   const CATEGORY = 'homirx_general';

   public function get_categories(){
      return array(self::CATEGORY);
   }
    
   public function get_name(){
      return self::NAME;
   }

   public function get_title() {
      return __( 'GVA User', 'homirx-themer' );
   }

   public function get_keywords() {
      return [ 'menu', 'user', 'block' ];
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
			'style',
			[
				'label' => __( 'Style', 'homirx-themer' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
				  'style-1' => esc_html__('Style 01', 'homirx-themer'),
				  'style-2' => esc_html__('Style 02', 'homirx-themer')
				],
				'default' => 'style-1',
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
         'hi_text',
         [
            'label'        => __('Hi Text', 'homirx-themer'),
            'type'         => Controls_Manager::TEXT,
            'default'      => __('Hi, ', 'homirx-themer')
         ]
      );
      $this->add_control(
         'login_text',
         [
            'label'        => __('Login Text', 'homirx-themer'),
            'type'         => Controls_Manager::TEXT,
            'default'      => __('Sign in', 'homirx-themer')
         ]
      );

      $this->add_control(
         'login_link',
         [
            'label'        => __('Custom Login Link', 'homirx-themer'),
            'type'         => Controls_Manager::TEXT,
            'label_block'  => true,
            'description'  => esc_html__('Empty = default link', 'zilom'),
         ]
      );
      $this->add_control(
         'register_text',
         [
            'label'        => __('Register Text', 'homirx-themer'),
            'type'         => Controls_Manager::TEXT,
            'default'      => __('Register', 'homirx-themer')
         ]
      );

      $this->add_control(
         'register_link',
         [
            'label'        => __('Custom Register Link', 'homirx-themer'),
            'type'         => Controls_Manager::TEXT,
            'label_block'  => true,
            'description'  => esc_html__('Empty = default link', 'zilom'),
         ]
      );

      $this->add_control(
         'selected_icon',
         [
            'label' => __( 'Icon', 'homirx-themer' ),
            'type' => Controls_Manager::ICONS,
            'fa4compatibility' => 'icon',
            'default' => [
               'value' => 'hicon-user',
               'library' => 'fa-solid',
            ],
         ]
      );

      $this->add_control(
         'menu',
         [
            'label'        => __( 'Menu', 'homirx-themer' ),
            'type'         => Controls_Manager::SELECT,
            'options'      => $this->get_all_menus(),
            'label_block'  => true,
            'default'      => 'main-user'
         ]
      );

      $this->add_control(
         'menu_width',
         [
            'label' => __( 'Menu Width (px)', 'homirx-themer' ),
            'type' => Controls_Manager::SLIDER,
            'default' => [
               'size' => 250,
            ],
            'range' => [
               'px' => [
                  'min' => 100,
                  'max' => 500,
               ],
            ],
            'selectors' => [
               '{{WRAPPER}} .gva-user .user-account' => 'min-width: {{SIZE}}{{UNIT}};',
            ],
         ]
      );
      $this->add_control(
         'menu_space',
         [
            'label' => __( 'Menu Space Top', 'homirx-themer' ),
            'type' => Controls_Manager::SLIDER,
            'range' => [
               'px' => [
                  'min' => 0,
                  'max' => 100,
               ],
            ],
            'selectors' => [
               '{{WRAPPER}} .gva-user .user-account' => 'margin-top: {{SIZE}}{{UNIT}};',
            ],
         ]
      );
      
      $this->end_controls_section();

      // Style
       $this->start_controls_section(
         'section_general_style',
         [
            'label' => __( 'General', 'homirx-themer' ),
            'tab' => Controls_Manager::TAB_STYLE,
         ]
      );
      $this->add_control(
         'avatar_width',
         [
            'label' => __( 'Avatar Width', 'homirx-themer' ),
            'type' => Controls_Manager::SLIDER,
            'range' => [
               'px' => [
                  'min' => 20,
                  'max' => 200,
               ],
            ],
            'selectors' => [
               '{{WRAPPER}} .gva-user .login-account .profile .avata' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};',
            ],
         ]
      );
      $this->add_control(
         'text_color',
         [
            'label' => __( 'Text Color', 'homirx-themer' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
               '{{WRAPPER}} .gva-user.style-2 .login-account .profile' => 'color: {{VALUE}}',
               '{{WRAPPER}} .gva-user.style-2 .login-register' => 'color: {{VALUE}}',
               '{{WRAPPER}} .gva-user.style-2 .login-register a' => 'color: {{VALUE}}',
               '{{WRAPPER}} .gva-user.style-1 .login-account.without-login .profile .avata-icon' => 'border-color: {{VALUE}}',
               '{{WRAPPER}} .gva-user.style-1 .login-account.without-login .profile .avata-icon' => 'color: {{VALUE}}',
            ],
         ]
      );
      $this->add_control(
         'text_hover_color',
         [
            'label' => __( 'Hover Color', 'homirx-themer' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
               '{{WRAPPER}} .gva-user.style-2 .login-account .profile:hover' => 'color: {{VALUE}}',
               '{{WRAPPER}} .gva-user.style-2 .login-register a:hover' => 'color: {{VALUE}}',
               '{{WRAPPER}} .gva-user.style-1 .login-account.without-login .profile .avata-icon:hover' => 'background-color: {{VALUE}}',
               '{{WRAPPER}} .gva-user.style-1 .login-account.without-login .profile .avata-icon:hover' => 'border-color: {{VALUE}}',
            ],
         ]
      );

      $this->add_control(
         'heading_icon_style',
         [
            'label' => __( 'Icon ---', 'homirx-themer' ),
            'type' => Controls_Manager::HEADING,
         ]
      );
      $this->add_responsive_control(
         'icon_size',
         [
            'label' => __( 'Icon Size', 'homirx-themer' ),
            'type' => Controls_Manager::SLIDER,
            'range' => [
               'px' => [
                  'min' => 10,
                  'max' => 100,
               ],
            ],
            'selectors' => [
               '{{WRAPPER}} .gva-user .login-account .profile .avata-icon i' => 'font-size: {{SIZE}}{{UNIT}};',
               '{{WRAPPER}} .gva-user .login-account .profile .avata-icon svg' => 'width: {{SIZE}}{{UNIT}};',
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
               '{{WRAPPER}} .gva-user .login-account .profile .avata-icon' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
         ]
      );

      $this->add_control(
         'section_menu_style',
         [
            'label' => __( 'Menu Style ---', 'homirx-themer' ),
            'type'      => Controls_Manager::HEADING,
         ]
      );
      $this->add_control(
         'account_menu_color',
         [
            'label'     => __('Color', 'homirx-themer'),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .gva-user .login-account .user-account .my_account_nav_list > li > a' => 'color: {{VALUE}}',
            ],
         ]
      );
      $this->add_control(
         'account_menu_color_hover',
         [
            'label'     => __('Color Hover', 'homirx-themer'),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .gva-user .login-account .user-account .my_account_nav_list > li > a:hover' => 'color: {{VALUE}}',
            ],
         ]
      );

      $this->add_group_control(
         Group_Control_Typography::get_type(),
         [
            'name' => 'typography',
            'selector' => '{{WRAPPER}} .gva-user .login-account .user-account .my_account_nav_list > li > a',
         ]
      );

      $this->add_responsive_control(
         'main_menu_padding',
         [
            'label' => __( 'Menu Item Padding', 'homirx-themer' ),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', '%' ],
            'selectors' => [
               '{{WRAPPER}} .gva-user .login-account .user-account .my_account_nav_list > li > a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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

$widgets_manager->register(new GVAElement_User());
