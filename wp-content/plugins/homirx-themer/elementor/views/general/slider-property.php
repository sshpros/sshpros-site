<?php
   if(!defined('ABSPATH')){ exit; }
   use Elementor\Icons_Manager;
   $classes = array();
   $classes[] = 'slider-property swiper-slider-property ' . $settings['style'];
   $this->add_render_attribute('wrapper', 'class', $classes);

   $carousel_options = array(
      'space_between'       => isset($settings['space_between']) ? intval($settings['space_between']) : 20,
      'loop'                => $settings['ca_loop'] === 'yes' ? 1 : 0,
      'speed'               => $settings['ca_speed'],
      'autoplay'            => $settings['ca_autoplay'] === 'yes' ? 1 : 0,
      'autoplay_delay'      => $settings['ca_autoplay_delay'],
      'autoplay_hover'      => $settings['ca_autoplay_hover'] === 'yes' ? 1 : 0,
      'navigation'          => $settings['ca_navigation'] === 'yes' ? 1 : 0,
      'pagination'          => $settings['ca_pagination'] === 'yes' ? 1 : 0
   );
   $carousel_params = htmlspecialchars(json_encode($carousel_options));

?>

<div <?php echo $this->get_render_attribute_string('wrapper'); ?>>
   <div class="swiper-content-inner">
      <div class="init-slider-property swiper" data-carousel="<?php echo $carousel_params ?>">
         <div class="swiper-wrapper">
            <?php 
            	foreach ($settings['carousel_content'] as $item){
               	include $this->get_template('general/slider-property/item-' . $item['style'] . '.php');
            	} 
            ?>
         </div>
         <div class="slider-property-preloader"></div>
      </div>
   </div>   
   <div class="slider-meta">
      <?php echo ($settings['ca_pagination'] ? '<div class="swiper-pagination"></div>' : '' ); ?>
      <?php echo ($settings['ca_navigation'] ? '<div class="swiper-nav-next">NEXT</div><div class="swiper-nav-prev">PREVIEWS</div>' : '' ); ?>
   </div>
</div>
