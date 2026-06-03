<?php
/**
 * @author  wpWax
 * @since   6.6
 * @version 7.10.0
 */

if ( ! defined( 'ABSPATH' ) ) exit;

?>

<div class="property-listing-link">
   <a href="<?php echo esc_url($listings->loop['permalink']) ?>">
      <?php 
         if($icon){ 
            echo '<i class="icon ' . esc_attr($icon) . '"></i>';
         } 
      ?>
      <?php echo esc_html($data['label_link']); ?>
   </a>
</div>