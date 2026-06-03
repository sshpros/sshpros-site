<?php
   global $wp_query;
   $this->add_render_attribute( 'block', 'class', [ 'gva-navigation-menu', ' menu-align-' . $settings['align'] ] );
   $args = [
      'echo'        => false,
      'menu'        => !empty($settings['menu']) ? $settings['menu'] : 'main-menu',
      'menu_class'  => 'gva-nav-menu gva-main-menu',
      'menu_id'     => 'menu-' . wp_rand(5),
      'container'   => 'div'
   ];

   if(class_exists('Homirx_Walker')){
      $args['walker' ]     = new Homirx_Walker();
   }
   
   $menu_html = wp_nav_menu($args);

   if (empty($menu_html)) {
      return;
   }
?>

<div <?php echo $this->get_render_attribute_string( 'block' ) ?>>
   <?php echo $menu_html; ?>
</div>

