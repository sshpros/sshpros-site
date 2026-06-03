<?php
/**
 * @author  wpWax
 * @since   6.6
 * @version 6.7
 */
if ( ! defined( 'ABSPATH' ) ) exit;

?>

<div class="property-card-text">
   <?php 
      if($icon){ 
         echo '<i class="icon ' . esc_attr($icon) . '"></i>';
      } 
   ?>
   <?php if($label){ ?>
   	<span class="label"><?php echo wp_kses_post($label) ?></span>
	<?php } ?>
   <span class="value"><?php echo esc_html( $value ); ?></span>
</div>