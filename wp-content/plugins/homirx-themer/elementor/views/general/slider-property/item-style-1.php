<div class="swiper-slide item-wrap-<?php echo $item['style'] ?>">
   <div class="slider-item-content slide-<?php echo $item['style'] ?>">
      <?php if($item['image']['url']){ ?>
         <div class="slider-image">
            <img data-swiper-parallax="1200" src="<?php echo esc_url($item['image']['url']) ?>" alt="<?php echo esc_html($item['title']) ?>"/>
            <div class="slider-image-overlay"></div>
         </div>
      <?php } ?>

      <div class="slider-content">
         <div class="slider-content-width">
            <?php 
               echo '<div class="layer-wrap property-content">';
                  echo '<div class="layer-inner">';
                     echo '<div class="slider-caption" data-animation="fadeInRight" data-delay="1000ms" data-duration="1000ms">';
                       	echo '<div class="layer-property">';
                          	
                          	echo '<div class="layer-property__top">';
                             	echo '<div class="layer-property__sub-title">';
                              	echo $item['sub_title'];
                             	echo '</div>';
                             	echo '<div class="layer-property__title">';
                           		echo $item['title'];
                           	echo '</div>';
                           echo '</div>';

                           echo '<div class="layer-property__content">';
                              echo '<div class="layer-property__location">';
                              	echo '<div class="layer-property__location-label">' . esc_html__('Location', 'homirx-themer') . '</div>';
                              	echo '<div class="layer-property__location-text">' . $item['location'] . '</div>';
                              echo '</div>';

                              echo '<div class="layer-property__information">';
                              	echo $item['info'];
                              echo '</div>';

                              echo '<div class="layer-property__meta">';
                              	echo '<div class="layer-property__price">';
                              		echo $item['price'];
                              	echo '</div>';
                              	if($item['image_second']['url']){
                              		echo '<div class="layer-property__avata">';
                                 		echo '<img src="' . esc_url($item['image_second']['url']) . '" alt="'. esc_html($item['title']) . '"/>';
                                 	echo '</div>';
                                 }
                              echo '</div>';
                           
                              if($item['btn_link']['url']){
                                 echo '<div class="layer-property__action">';
                                 	$_rand = wp_rand();
                                    $this->add_link_attributes('link_' . $_rand, $item['btn_link']);
                                    echo '<a class="slider-caption layer-property__btn" data-animation="fadeInUp" data-delay="1600ms" data-duration="1000ms" ' . $this->get_render_attribute_string( 'link_' . $_rand ) . '><span>';
                                       echo $item['btn_title'];
                                    echo '</span></a>';
                                 echo '</div>';
                              }
                           echo '</div>';
                              
                        echo '</div>';
                     echo '</div>';
                  echo '</div>';
               echo '</div>';

               // Custom Links
               echo '<div class="layer-wrap property-link">';
               	echo '<div class="layer-inner">';
                     echo '<div class="slider-caption" data-animation="fadeInUp" data-delay="1500ms" data-duration="1000ms">';
                     	echo $item['custom_html'];
                     echo '</div>';
                  echo '</div>';
               echo '</div>';
            ?>
         </div>
      </div> 
      <div class="slider-overlay"></div>
      <div data-animation="fadeInDown" data-delay="1200ms" data-duration="1000ms" class="slider-overlay-1"></div>
      <div data-animation="fadeInUp" data-delay="1400ms" data-duration="1000ms" class="slider-overlay-2"></div>
   </div>
</div>