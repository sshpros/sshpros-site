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
            <div class="slider-content-left">
	            <div class="layer-wrap property-content">
	               <div class="layer-inner">';
	                  <div class="slider-caption" data-animation="fadeInUp" data-delay="1000ms" data-duration="1000ms">
	                     <div class="layer-property">
	                          	
                          	<div class="layer-property__top">
                             	<div class="layer-property__sub-title">
                              	<?php echo $item['sub_title']; ?>
                             	</div>
                             	<div class="layer-property__title">
                           		<?php echo $item['title']; ?>
                           	</div>
                           </div>

                           <div class="layer-property__content">
                              <div class="layer-property__location">
                              	<div class="layer-property__location-label">
                              		<?php echo esc_html__('Location', 'homirx-themer') ?>
                              	</div>
                              	<div class="layer-property__location-text">
                              		<?php echo $item['location'] ?>
                              	</div>
                              </div>

                              <div class="layer-property__information">
                              	<?php echo $item['info']; ?>
                              </div>

                              <div class="layer-property__meta">
                              	<div class="layer-property__price">
                              		<?php echo $item['price']; ?>
                              	</div>
                              </div>
                           
                              <?php 
                              	if($item['btn_link']['url']){ 
	                              	$_rand = wp_rand();
	                              	$this->add_link_attributes('link_' . $_rand, $item['btn_link']);
                              ?>
                                 <div class="layer-property__action">
                                    <a class="slider-caption layer-property__btn" data-animation="fadeInUp" data-delay="1600ms" data-duration="1000ms" <?php echo $this->get_render_attribute_string( 'link_' . $_rand ) ?>>
                                    	<span>
                                       	<?php echo $item['btn_title']; ?>
                                    	</span>
                                 	</a>
                                 </div>
                              <?php } ?>
                           </div>
	                              
	                     </div>
	                  </div>
	               </div>
	            </div>
	         </div>

            <div class="slider-content-right">
            	<div class="layer-wrap property-explore">
               	<div class="layer-inner">
                     <div class="slider-caption" data-animation="fadeInUp" data-delay="1000ms" data-duration="1000ms">
                     	<?php if($item['image_second']['url']){ ?>
                     		<div class="image">
                        		<img src="<?php echo esc_url($item['image_second']['url']) ?>" alt="<?php echo esc_html($item['title']) ?>"/>
                        	</div>
                        <?php } ?>
                     	<div class="slider-caption explore-arrow" data-animation="fadeInRight" data-delay="2500ms" data-duration="1000ms">
                           <div class="inner">
                              <i aria-hidden="true" class=" hicon-arrow-right-1"></i>
                              <svg viewBox="0 0 100 100" width="100" height="100">
                                <defs>
                                  <path id="circle"
                                    d="
                                      M 50, 50
                                      m -37, 0
                                      a 37,37 0 1,1 74,0
                                      a 37,37 0 1,1 -74,0"/>
                                </defs>
                                <text font-size="5">
                                  <textPath xlink:href="#circle">
                                    <?php echo esc_html__('Explore Our All Property', 'homirx-themer') ?>
                                  </textPath>
                                </text>
                              </svg>

                              <?php $this->gva_render_link_overlay($item['btn_link'], 'ovelay-link') ?>

                           </div>
                     	</div>
                     </div>
                  </div>
               </div>
           
               <div class="layer-wrap property-link">
               	<div class="layer-inner">
                     <div class="slider-caption" data-animation="fadeInUp" data-delay="1500ms" data-duration="1000ms">
                     	<?php echo $item['custom_html']; ?>
                     </div>
                  </div>
               </div>
            </div>

         </div>
      </div> 
      <div class="slider-overlay"></div>
      <div data-animation="fadeInDown" data-delay="1200ms" data-duration="1000ms" class="slider-overlay-1"></div>
      <div data-animation="fadeInUp" data-delay="1400ms" data-duration="1000ms" class="slider-overlay-2"></div>
   </div>
</div>