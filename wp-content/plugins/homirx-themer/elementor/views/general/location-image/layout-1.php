<?php
   if (!defined('ABSPATH')) {
      exit; // Exit if accessed directly.
   }
   use Elementor\Icons_Manager;
   $_rand = wp_rand(5);
   $accordion_id = "accordion-" . esc_attr($_rand);
?>

<div class="location-one__single">
   <div class="location-one__wrap"> 
      <?php 
         if( isset($settings['image']['url']) && $settings['image']['url'] ){
            echo '<div class="location-one__image-main">';
               echo '<img src="' . esc_url($settings['image']['url']) . '" alt="' . esc_attr($settings['title_text']) . '"/>';
            echo '</div>';
         }
      ?>
      <div class="location-one__main-content">
         <?php 
            $i = 0;
            foreach ($settings['location_content'] as $item){
            	$active = $item['active'] == 'yes' ? 'active' : '';
               $i++;
               $classes = 'elementor-repeater-item-'. esc_attr($item['_id']) . ' item-' . esc_attr($i) . ' ' . $active;
               echo '<div class="location-one__location ' . $classes . '">';
                  echo '<a href="#" class="location-one__marker"></a>';
                  
                  echo '<div class="location-one__box">';
                     echo '<div class="location-one__popup">';
                     	if( isset($item['image']['url']) && $item['image']['url'] ){
	                        echo '<div class="location-one__image">';
	                        	echo '<img src="' . esc_url($item['image']['url']) . '" alt="' . esc_attr($item['title']) . '"/>';
	                        echo '</div>';
	                     }
                        
                        echo '<div class="location-one__content">';
                           
                           echo '<div class="location-one__meta">';
                           	echo '<div class="location-one__meta-label">' . esc_html__('Address:', 'homirx-themer') .'</div>';
                           	echo '<div class="location-one__meta-value">' . $item['address'] .'</div>';
                           echo '</div>';

                           if($item['post_code']){
                           	echo '<div class="location-one__meta">';
	                              echo '<div class="location-one__meta-label">' . esc_html__('Post Code:', 'homirx-themer') . '</div>';
	                              echo '<div class="location-one__meta-value">' . $item['post_code'] . '</div>';
	                           echo '</div>';
                           }

                          if($item['btn_link']['url']){
                              echo '<div class="location-one__action">';
                              	$_rand = wp_rand();
                                 $this->add_link_attributes('link_' . $_rand, $item['btn_link']);
                                 echo '<a class="btn-theme" ' . $this->get_render_attribute_string( 'link_' . $_rand ) . '><span>';
                                    echo esc_html__('Direction', 'homirx-themer');
                                 echo '</span></a>';
                              echo '</div>';
                           }
                        echo '</div>';

                     echo '</div>';
                  echo '</div>';  

               echo '</div>';

            }
         ?>
      </div>
   </div>
</div>
