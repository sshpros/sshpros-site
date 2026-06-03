<?php
   if (!defined('ABSPATH')){ exit; }

   global $homirx_post, $post;
   if( !$homirx_post ){ return; }
   if( $homirx_post->post_type != 'product' ){ return; }

   $this->add_render_attribute('block', 'class', [ 'product-item-excerpt' ]);
?>

<div <?php echo $this->get_render_attribute_string( 'block' ) ?>>
   <div itemprop="description">
      <?php echo apply_filters( 'woocommerce_short_description', $homirx_post->post_excerpt ) ?>
   </div>
</div>
