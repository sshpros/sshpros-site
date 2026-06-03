<?php
	$rand = gaviasthemer_random_id();
   $style = $settings['style'];
   $this->add_render_attribute( 'link', 'href', $settings['link']['url'] );
   $this->add_render_attribute( 'link', 'class', 'popup-video' );
   if ( $settings['link']['is_external'] ) {
      $this->add_render_attribute( 'link', 'target', '_blank' );
   }
   if ( $settings['link']['nofollow'] ) {
      $this->add_render_attribute( 'link', 'rel', 'nofollow' );
   }

   ?>

   <?php if($style == 'style-1'){ ?>
      <div class="video-one__single">
         <div class="video-one__inner">
            <?php if(isset($settings['image']['url']) && $settings['image']['url']){ ?>
               <div class="video-one__image">
                  <a <?php echo $this->get_render_attribute_string( 'link' ) ?>>
                     <img src="<?php echo esc_url($settings['image']['url']) ?>" alt="<?php echo esc_html($settings['title_text']) ?>"/>
                  </a>   
               </div>
            <?php } ?>   
            <div class="video-one__content">
               <div class="video-one__action">
                  <?php 
                     echo '<a '. $this->get_render_attribute_string( 'link' ) . '><i class="fa fa-play"></i></a>';
                  ?>  
               </div>   
            </div>    
         </div>
      </div> 
   <?php } ?>

   <?php if($style == 'style-2'){ ?>
      <div class="video-two__single">
         <div class="video-two__inner">
            <div class="video-two__content">
               <div class="video-two__action">
                  <span class="video-two__icon"><i class="fa fa-play"></i></span>
               </div>
               <svg class="video-two__rotatingText" viewBox="0 0 200 200" width="200" height="200">
                  <defs>
                    <path id="circle_<?php echo $rand ?>" d="M 100, 100 m -75, 0 a 75, 75 0 1, 0 150, 0 a 75, 75 0 1, 0 -150, 0"></path>
                  </defs>
                  <text>
                    <textPath xlink:href="#circle_<?php echo $rand ?>" class="video-two__title">
                     <?php if( $settings['title_text'] ){ ?>
                        <?php echo $settings['title_text'] ?>
                     <?php } ?>
                    </textPath>
                  </text>
               </svg>
               <?php $this->add_render_attribute( 'link', 'class', 'video-two__link' ); ?>
               <a <?php echo $this->get_render_attribute_string( 'link' ) ?>></a>
            </div>    
         </div>
      </div> 
   <?php } ?>
   
   <?php if($style == 'style-3'){ ?>
      <div class="video-three__single">
         <div class="video-three__inner">
            <?php if(isset($settings['image']['url']) && $settings['image']['url']){ ?>
               <div class="video-three__image">
                  <a <?php echo $this->get_render_attribute_string( 'link' ) ?>>
                     <img src="<?php echo esc_url($settings['image']['url']) ?>" alt="<?php echo esc_html($settings['title_text']) ?>"/>
                  </a>   
               </div>
            <?php } ?>   
            <div class="video-three__content">
               <div class="video-three__action">
                  <?php 
                     echo '<a ' . $this->get_render_attribute_string( 'link' ) . '><i class="fa fa-play"></i></a>';
                  ?>  
               </div>   
            </div>    
         </div>
      </div> 
   <?php } ?>
   <?php if($style == 'style-4'){ ?>
      <div class="video-four__single">
         <div class="video-four__inner">
            <div class="video-four__content">
               <div class="video-four__action">
                  <a <?php echo $this->get_render_attribute_string( 'link' ) ?>><span><i class="fab fa-youtube"></i></span></a>
               </div>
               <?php if( $settings['title_text'] ){ ?>
                  <div class="video-four__title"><?php echo $settings['title_text'] ?></div>
               <?php } ?>
            </div>    
         </div>
      </div> 
   <?php } ?>
 <?php if($style == 'style-5'){ ?>
      <div class="video-five__single">
         <div class="video-five__inner">
            <div class="video-five__content">
               <div class="video-five__action">
                  <a <?php echo $this->get_render_attribute_string( 'link' ) ?>><span><i class="fa fa-play"></i></span></a>
               </div>
               <?php if( $settings['title_text'] ){ ?>
                  <div class="video-five__title"><?php echo $settings['title_text'] ?></div>
               <?php } ?>
            </div>    
         </div>
      </div> 
   <?php } ?>
 
