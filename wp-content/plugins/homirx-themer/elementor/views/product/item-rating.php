<?php
   if (!defined('ABSPATH')){ exit; }

   global $homirx_post, $post;

   if( !$homirx_post ){ return; }
   if( $homirx_post->post_type != 'product' ){ return; }

   $this->add_render_attribute('block', 'class', [ 'product-item-rating' ]);
?>

<div <?php echo $this->get_render_attribute_string( 'block' ) ?>>
   <?php if(\Elementor\Plugin::$instance->editor->is_edit_mode() || $post->post_type == 'gva__template'){ ?>
      <div class="woocommerce-product-rating" itemprop="aggregateRating" itemscope="" itemtype="http://schema.org/AggregateRating">
         <div class="star-rating" title="Rated 0 out of 5"></div>
         <a href="#reviews" class="woocommerce-review-link" rel="nofollow">(<span itemprop="reviewCount" class="count">0</span> customer reviews)</a> 
      </div>
   <?php } else{
      woocommerce_template_single_rating(); 
   } ?>
</div>   