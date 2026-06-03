<?php
/**
 * @author  wpWax
 * @since   6.7
 * @version 7.3.1
 */

if ( ! defined( 'ABSPATH' ) ) exit;

if ( !$has_slider ) {
   return;
}
$img_size_class = ( 'contain' === $data['background-size'] ) ? '' : ' plasmaSlider__cover';
?>

<div class="property-single-slider" style="overflow: hidden;">
	<div class="swiper-container slider">
	   <div class="swiper-wrapper">
	   	<?php 
	   	if ( ! empty( $data['images'] )  ) :
				foreach ( $data['images'] as $image ) : 
			?>
		        	<div class="swiper-slide">
		        		<img src="<?php echo esc_url($image['src']) ?>" alt="<?php echo esc_attr( $image['alt'] ); ?>">
		        	</div>
		      <?php
		      endforeach;
			endif; 
			?>

	   </div>
	   <div class="swiper-nav-next"></div>
	   <div class="swiper-nav-prev"></div>
	</div>

	<div class="swiper-container slider-thumbnail">
	   <div class="swiper-wrapper">
	      <?php 
		   	if ( ! empty( $data['images'] ) && count($data['images']) > 1 ) :
					foreach ( $data['images'] as $image ) : 
				?>
			        	<div class="swiper-slide">
			        		<img src="<?php echo esc_url($image['src']) ?>" alt="<?php echo esc_attr( $image['alt'] ); ?>">
			        	</div>
			      <?php
			      endforeach;
				endif; 
			?>
	   </div>
	</div>
</div>