<?php
/**
 * @author  wpWax
 * @since   6.6
 * @version 6.7
 */
if ( ! defined( 'ABSPATH' ) ) exit;
?>

<div class="property-card-number">
   <?php 
      if($icon){ 
         echo '<i class="icon ' . esc_attr($icon) . '"></i>';
      } 
   ?>
   <span class="value"><?php echo wp_kses_post($label) . ' ' . esc_html( $value ); ?></span>
</div>