<?php
   if (!defined('ABSPATH')) {
      exit; // Exit if accessed directly.
   }
   use Elementor\Icons_Manager;

   extract( $settings );

   $this->add_render_attribute('wrapper', 'class', ['gsc-listings-banner-group layout-carousel swiper-slider-wrapper', $settings['style']]);
   
   $style = $settings['style'] ? $settings['style'] : 'style-1';
?>

<div <?php echo $this->get_render_attribute_string('wrapper'); ?>>
   <div class="swiper-content-inner">
      <div class="init-carousel-swiper swiper" data-carousel="<?php echo $this->get_carousel_settings() ?>">
         <div class="swiper-wrapper">
            <?php
               foreach ($settings['content_banners'] as $banner): 
                  echo '<div class="swiper-slide">';
                     include $this->get_template('general/banner-group/item-' . $style . '.php');
                  echo '</div>';
               endforeach; 
            ?>
         </div>
      </div>      
   </div>
   <?php echo ($settings['ca_pagination'] ? '<div class="swiper-pagination"></div>' : '' ); ?>
   <?php echo ($settings['ca_navigation'] ? '<div class="swiper-nav-next"></div><div class="swiper-nav-prev"></div>' : '' ); ?> 
</div>
