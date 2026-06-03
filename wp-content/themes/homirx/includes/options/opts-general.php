<?php
Redux::setSection( $opt_name, array(
	'title' => esc_html__('General Options', 'homirx'),
	'icon' => 'el-icon-wrench',
	'fields' => array(
      array(
        'id'      => 'header_settings',
        'type'    => 'info',
        'raw'     => '<h3 class="mb-0">' . esc_html__('Header settings', 'homirx') . '</h3>'
      ),
      array(
        'id'      => 'header_logo', 
        'type'    => 'media',
        'url'     => true,
        'title'   => esc_html__('Logo in header default', 'homirx'), 
        'default' => ''
      ),  
      array(
        'id'      => 'footer_settings',
        'type'    => 'info',
        'raw'     => '<h3 class="mb-0">' . esc_html__('Footer settings', 'homirx') . '</h3>'
      ),
      array(
         'id'        => 'copyright_default',
         'type'      => 'button_set',
         'title'     => esc_html__('Enable/Disable Copyright Text', 'homirx'),
         'options'   => array(
            'yes'    => esc_html__('Enable', 'homirx'),
            'no'     => esc_html__('Disable', 'homirx')
         ),
         'default'   => 'yes'
      ),
      array(
         'id'        => 'copyright_text',
         'type'      => 'editor',
         'title'     => esc_html__('Footer Copyright Text', 'homirx'),
         'default'   => esc_html__('Copyright - 2024 - Company - All rights reserved. Powered by WordPress.', 'homirx')
      ),
      array(
        'id'      => 'page_layout_settings',
        'type'    => 'info',
        'raw'     => '<h3 class="mb-0">' . esc_html__('Page Layout', 'homirx') . '</h3>'
      ),
		array(
			'id'           => 'page_layout',
			'type'         => 'button_set',
			'title'        => esc_html__('Page Layout', 'homirx'),
			'subtitle'     => esc_html__('Select the page layout type', 'homirx'),
			'options'      => array(
				'boxed'     => esc_html__('Boxed', 'homirx'),
				'fullwidth' => esc_html__('Fullwidth', 'homirx')
			),
			'default' => 'fullwidth'
		),
      

		// Breadcrumb Default Settings
		array(
         'id'     => 'breadcrumb_default',
         'type'   => 'info',
         'icon'   => true,
         'raw'    => '<h3 class="mb-0">' . esc_html__('Breadcrumb Settings Without Elementor', 'homirx') . '</h3>',
      ),
		array(
         'id'        => 'breadcrumb_title',
         'type'      => 'button_set',
         'title'     => esc_html__('Breadcrumb Title', 'homirx'),
         'options'   => array(
            1 => esc_html__('Enable', 'homirx'),
            0 => esc_html__('Disable', 'homirx')
         ),
         'default'   => 1
      ),
      array(
         'id'        => 'breadcrumb_padding_top',
         'type'      => 'slider',
         'title'     => esc_html__('Breadcrumb Padding Top', 'homirx'),
         'default'   => 120,
         'min'       => 50,
         'max'       => 500,
         'step'      => 1,
         'display_value' => 'text',
      ),
      array(
         'id'        => 'breadcrumb_padding_bottom',
         'type'      => 'slider',
         'title'     => esc_html__('Breadcrumb Padding Top', 'homirx'),
         'default'   => 120,
         'min'       => 50,
         'max'       => 500,
         'step'      => 1,
         'display_value' => 'text',
      ),
      array(
         'id'        => 'breadcrumb_bg_color',
         'type'      => 'color',
         'title'     => esc_html__('Background Overlay Color', 'homirx'),
         'default'   => ''
      ),
      array(
         'id'        => 'breadcrumb_bg_opacity',
         'type'      => 'slider',
         'title'     => esc_html__('Breadcrumb Ovelay Color Opacity', 'homirx'),
         'default'   => 50,
         'min'       => 0,
         'max'       => 100,
         'step'      => 2,
         'display_value' => 'text',
      ),
      array(
         'id'        => 'breadcrumb_bg_image',
         'type'      => 'media',
         'url'       => true,
         'title'     => esc_html__('Breadcrumb Background Image', 'homirx'),
         'default'   => '',
      ),
      array(
         'id'        => 'breadcrumb_text_stype',
         'type'      => 'select',
         'title'     => esc_html__('Breadcrumb Text Stype', 'homirx'),
         'options'   => 
         array(
            'text-light'     => esc_html__('Light', 'homirx'),
            'text-dark'      => esc_html__('Dark', 'homirx')
         ),
         'default' => 'text-light'
      )
	)
));