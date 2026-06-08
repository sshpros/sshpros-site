<?php
$homirx_options = homirx_get_options();
$logo = ( isset( $homirx_options['header_logo']['url'] ) && $homirx_options['header_logo']['url'] )
    ? $homirx_options['header_logo']['url']
    : get_template_directory_uri() . '/assets/images/logo.png';
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div class="wrapper-page">

    <div class="header-mobile header_mobile_screen">
        <div class="header-mobile-content">
            <div class="header-content-inner clearfix">
                <div class="header-left">
                    <div class="logo-mobile">
                        <a href="<?php echo esc_url( home_url( '/' ) ); ?>">
                            <img src="<?php echo esc_url( $logo ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>">
                        </a>
                    </div>
                </div>
                <div class="header-right">
                    <button class="navbar-toggle mobile-toggle" type="button">
                        <span class="sr-only"><?php esc_html_e( 'Toggle navigation', 'homirx-child' ); ?></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <header class="header-default">
        <div class="header_default_screen">
            <div class="header-bottom">
                <div class="container">
                    <div class="header-bottom-inner">
                        <div class="logo">
                            <a class="logo-theme" href="<?php echo esc_url( home_url( '/' ) ); ?>">
                                <img src="<?php echo esc_url( $logo ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>">
                            </a>
                        </div>
                        <div class="main-menu-inner">
                            <div class="content-innter clearfix">
                                <div id="gva-mainmenu" class="main-menu">
                                    <?php
                                    wp_nav_menu( array(
                                        'theme_location' => 'primary',
                                        'container'      => 'div',
                                        'container_class'=> 'navbar-collapse',
                                        'menu_class'     => 'navbar-nav',
                                    ) );
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <div id="page-content">
