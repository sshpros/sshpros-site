<?php
	$classes = array();
	$classes[] = 'gallery-property swiper-slider-wrapper';
   $this->add_render_attribute('wrapper', 'class', $classes);
   $_random = gaviasthemer_random_id();
?>

<div <?php echo $this->get_render_attribute_string('wrapper'); ?>>
	<div class="swiper-content-inner">
   	<div class="init-carousel-swiper swiper" data-carousel="<?php echo $this->get_carousel_settings() ?>">
      	<div class="swiper-wrapper">
				<?php foreach ($settings['contents'] as $item){ ?>
						<div class="swiper-slide item">
						   <div class="gallery-property-one">
							   <div class="gallery-property-one__wrap">
							      <?php if($item['image']['url']){ ?>
							         <div class="gallery-property-one__image">
							            <img src="<?php echo esc_url($item['image']['url']) ?>" alt="<?php echo esc_html($item['title']) ?>" />  
							         </div>
							      <?php } ?>

							      <div class="gallery-property-one__content">
							      	<?php if($item['image_second']['url']){ ?>
								         <div class="gallery-property-one__content-left">
							            	<img src="<?php echo esc_url($item['image_second']['url']) ?>" alt="<?php echo esc_html($item['title']) ?>" />  
								         </div>	
								      <?php } ?>
							         <div class="gallery-property-one__content-right">
							            <?php if($item['title']){ ?>
							               <h3 class="gallery-property-one__title"><?php echo $item['title'] ?></h3>
							            <?php } ?>
							            <?php if($item['address']){ ?>
							               <div class="gallery-property-one__info address">
							               	<div class="gallery-property-one__label"><?php echo esc_html__('Address', 'homirx-themer') ?></div>
							               	 <div class="gallery-property-one__value"><?php echo $item['address'] ?></div>
							               </div>
							            <?php } ?>
							            <?php if($item['address']){ ?>
							               <div class="gallery-property-one__info postcode">
							               	<div class="gallery-property-one__label"><?php echo esc_html__('Post Code', 'homirx-themer') ?></div>
							               	 <div class="gallery-property-one__value"><?php echo $item['postcode'] ?></div>
							               </div>
							            <?php } ?>
							         </div>   
							      </div>
							   </div>
							</div>
						</div>
				<?php } ?>
			</div>
		</div>
	</div>
	<?php echo ($settings['ca_pagination'] ? '<div class="swiper-pagination"></div>' : '' ); ?>
   <?php echo ($settings['ca_navigation'] ? '<div class="swiper-nav-next"></div><div class="swiper-nav-prev"></div>' : '' ); ?>
</div>
