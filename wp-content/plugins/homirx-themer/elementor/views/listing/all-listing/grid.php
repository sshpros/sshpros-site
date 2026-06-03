<?php
   use \Directorist\Helper;
   if ( ! defined( 'ABSPATH' ) ) exit;

	$this->add_render_attribute('wrapper', 'class', ['all-listing listings-grid clearfix']);

	//add_render_attribute grid
	$this->add_render_attribute('grid', 'class', ['directorist-items directorist-archive-grid-view']);
	$this->get_grid_settings();
?>
<div <?php echo $this->get_render_attribute_string('wrapper'); ?>>
   	<div class="directorist-main-items" <?php $listings->data_atts(); ?>>
   		<?php 
            if($settings['type_nav'] == 'yes'){
               $listings->directory_type_nav_template(); 
            }
         ?>
         <div <?php echo $this->get_render_attribute_string('grid') ?>>
           	<?php 
	            if($listings->have_posts()){
                  foreach( $listings->post_ids() as $listing_id ){
                     echo '<div class="item-columns">';
                        //homirx_themer_loop_template($listings, 'grid-02', $listing_id );
                       $listings->loop_template( $settings['property_layout'], $listing_id );
                     echo '</div>';
                  }
	            }else{
	               echo '<div class="directorist-archive-notfound">' . esc_html__( 'No listings found.', 'homirx-themer' ) . '</div>';
	            }
            ?>
         </div>
   	</div>
</div>