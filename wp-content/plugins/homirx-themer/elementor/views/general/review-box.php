<?php
	use Elementor\Icons_Manager;
	$classes = array();
	$classes[] = 'review-box';
	$classes[] = $settings['style'];
   $this->add_render_attribute('wrapper', 'class', $classes);
   $_random = gaviasthemer_random_id();
?>
<div <?php echo $this->get_render_attribute_string('wrapper'); ?>>
	<div class="custormer-reviews">
		
		<?php foreach ($settings['contents'] as $item){ ?>
			<?php $has_icon = !empty($item['selected_icon']['value']); ?>
			<div class="box-review-item">
				<div class="review-item-wrap">
	            <h4 class="title">
	            	<?php 
		            	if($has_icon){ 
								Icons_Manager::render_icon($item['selected_icon'], [ 'aria-hidden' => 'true' ]); 
							}
						?>
	            	<?php echo esc_html($item['title']) ?>
	         	</h4>
	            <div class="box-content">
	              	<?php if($item['image']['url']){ ?>
		               <div class="image">
		                  <img src="<?php echo esc_url($item['image']['url']) ?>" alt="<?php echo esc_html($item['title']) ?>" />  
		               </div>
		            <?php } ?>
	               <div class="content">
	                  <div class="star">
	                  	<?php
	                  	 	for ($i=1; $i <= 5; $i++) {
		                  		if($i <= $item['review']){
		                  			echo '<i class="fas fa-star active"></i>';
		                  		}else{
		                  			echo '<i class="far fa-star"></i>';
		                  		}
		                  	}
	                     ?>
	                  </div>
	                  <div class="review">
	                  	<?php echo esc_html($item['desc']) ?>
	                  </div>
	               </div>
	            </div>
	         </div>
         </div>
		<?php } ?>
			
	</div>
</div>

