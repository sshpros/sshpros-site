<?php
/**
 	* Include the TGM_Plugin_Activation class.
*/
add_action( 'tgmpa_register', 'homirx_register_required_plugins' );

function homirx_register_required_plugins() {
	$plugins = array(
		array(
			'name'                     => esc_html__('Homirx Themer', 'homirx'),
	    	'slug'                    	=> 'homirx-themer',
	    	'required'                	=> true,
	    	'source'				   		=> 'https://gaviasthemes.com/plugins/homirx-themer.zip'
		),
		array(
			'name'                     => esc_html__('Elementor Page Builder', 'homirx'),
		   'slug'                     => 'elementor',
		   'required'                 => true,
		), 
		array(
			'name'                     => esc_html__('Directorist - Business Directory Plugin', 'homirx'),
		   'slug'                     => 'directorist',
		   'required'                 => true,
		),
		array(
			'name'                     => esc_html__('Directorist AddonsKit for Elementor', 'homirx'),
		   'slug'                     => 'addonskit-for-elementor',
		   'required'                 => true,
		),
		array(
			'name'                     => esc_html__('Redux Framework', 'homirx'),
		   'slug'                     => 'redux-framework',
		   'required'                 => true,
		),
		array(
			'name'                     => esc_html__('Meta Box', 'homirx'),
		   'slug'                     => 'meta-box',
		   'required'                 => true,
		),
		array(
			'name'                     => esc_html__('Contact Form 7', 'homirx'),
		   'slug'                     => 'contact-form-7',
		   'required'                 => true,
		),
		array(
			'name'                     => esc_html__('MailChimp', 'homirx'),
		   'slug'                     => 'mailchimp-for-wp',
		   'required'                 => true,
		),
		array(
			'name'                     => esc_html__('Events Calendar', 'homirx'), 
		   'slug'                     => 'the-events-calendar', 
		   'required'                 => true, 
		),
		array(
			'name'                     => esc_html__('Woocommerce', 'homirx'), 
		   'slug'                     => 'woocommerce',
		   'required'                 => false,
		),
	);
	$config = array(
		'default_path' => '', // Default absolute path to pre-packaged plugins.
		'menu' => 'tgmpa-install-plugins', // Menu slug.
		'has_notices' => true, // Show admin notices or not.
		'dismissable' => true, // If false, a user cannot dismiss the nag message.
		'dismiss_msg' => '', // If 'dismissable' is false, this message will be output at top of nag.
		'is_automatic' => false, // Automatically activate plugins after installation or not.
		'message' => '', // Message to output right before the plugins table.
		'strings' => array(
		'page_title' => esc_html__( 'Install Required Plugins', 'homirx' ),
		'menu_title' => esc_html__( 'Install Plugins', 'homirx' ),
		'installing' => esc_html__( 'Installing Plugin: %s', 'homirx' ), // %s = plugin name.
		'oops' => esc_html__( 'Something went wrong with the plugin API.', 'homirx' ),
		'notice_can_install_required' => _n_noop( 'This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.', 'homirx' ), // %1$s = plugin name(s).
		'notice_can_install_recommended' => _n_noop( 'This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.' , 'homirx' ), // %1$s = plugin name(s).
		'notice_cannot_install' => _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.', 'homirx' ), // %1$s = plugin name(s).
		'notice_can_activate_required' => _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.' , 'homirx'), // %1$s = plugin name(s).
		'notice_can_activate_recommended' => _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.' , 'homirx'), // %1$s = plugin name(s).
		'notice_cannot_activate' => _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.', 'homirx' ), // %1$s = plugin name(s).
		'notice_ask_to_update' => _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.' , 'homirx'), // %1$s = plugin name(s).
		'notice_cannot_update' => _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.' , 'homirx'), // %1$s = plugin name(s).
		'install_link' => _n_noop( 'Begin installing plugin', 'Begin installing plugins' , 'homirx'),
		'activate_link' => _n_noop( 'Begin activating plugin', 'Begin activating plugins', 'homirx' ),
		'return' => esc_html__( 'Return to Required Plugins Installer', 'homirx' ),
		'plugin_activated' => esc_html__( 'Plugin activated successfully.', 'homirx' ),
		'complete' => esc_html__( 'All plugins installed and activated successfully. %s', 'homirx' ), // %s = dashboard link.
		'nag_type' => 'updated' // Determines admin notice type - can only be 'updated', 'update-nag' or 'error'.
		)
	);
   tgmpa( $plugins, $config );
}