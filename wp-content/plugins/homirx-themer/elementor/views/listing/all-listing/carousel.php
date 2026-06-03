<?php
	use \Directorist\Helper;
	if ( ! defined( 'ABSPATH' ) ) exit;

	$classes = array();
	$classes[] = 'swiper-slider-wrapper';
	$classes[] = $settings['space_between'] < 15 ? 'margin-disable': '';
	$this->add_render_attribute('wrapper', 'class', $classes);
?>

<div class="all-listing listings-carousel">
   <div class="directorist-main-items" <?php $listings->data_atts(); ?> data-carousel="<?php echo $this->get_carousel_settings() ?>">
      <?php 
         if($settings['type_nav'] == 'yes'){
            $listings->directory_type_nav_template(); 
         }
      ?>
      <div class="directorist-items directorist-archive-carousel-view">
      	<?php if($listings->have_posts()){ ?>
      		<div <?php echo $this->get_render_attribute_string('wrapper'); ?>>
      			<div class="swiper-content-inner">
      				<div class="init-carousel-swiper swiper">
      					<div class="swiper-wrapper">
      						<?php
      							foreach( $listings->post_ids() as $listing_id ){
      	                     echo '<div class="swiper-slide">';
      	                        $listings->loop_template( $settings['property_layout'], $listing_id );
      	                     echo '</div>';
      	                  }
      						?>
      					</div>
      				</div>		
      			</div>
      			<?php echo ($settings['ca_pagination'] ? '<div class="swiper-pagination"></div>' : '' ); ?>
      			<?php echo ($settings['ca_navigation'] ? '<div class="swiper-nav-next"></div><div class="swiper-nav-prev"></div>' : '' ); ?> 
      	   </div>
         <?php 
      		}else{
               echo '<div class="directorist-archive-notfound">' . esc_html__( 'No listings found.', 'homirx-themer' ) . '</div>';
            }
         ?>
      </div>
   </div>
</div>
