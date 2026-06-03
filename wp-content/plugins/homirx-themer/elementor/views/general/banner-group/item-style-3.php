<?php
   use Elementor\Group_Control_Image_Size;
   use Elementor\Icons_Manager;

   $image_id = $banner['image']['id']; 
   $image_url = $banner['image']['url'];
   if($image_id){
      $attach_url = Group_Control_Image_Size::get_attachment_image_src($image_id, 'image', $settings);
      if($attach_url) $image_url = $attach_url;
   }

   $taxonomy = $settings['taxonomy'] ? $settings['taxonomy'] : 'job_listing_region';
   $term = $link_term = false;
   if( !empty($banner['term_slug']) ){
      $term = get_term_by( 'slug', $banner['term_slug'], $taxonomy );
      if($term){
         $link_term = get_term_link( $term->term_id, $taxonomy );
      }
   }

   $has_icon = !empty($banner['icon']['value']);

   $target = '';
   if( !empty($banner['custom_link']['url']) ){ 
      $link_term = $banner['custom_link']['url'];
      if($banner['custom_link']['is_external']){
         $target = 'target="_blank"';
      }
   }

   $term_count = 0;
   if(!is_wp_error($term) && $settings['show_number_content'] == 'yes'){
      $term_count = isset($term->count) ? $term->count : 0;
      $term_childs = get_terms(array(
         'taxonomy' => $taxonomy,
         'parent'   => isset($term->term_id) ? $term->term_id : 0,
         'hide_empty' => true,
      ));
      if(!is_wp_error($term_childs)){
         foreach ($term_childs as $key => $term_child) {
           $term_count += $term_child->count;
         }
      }
   }
?>

<div class="item banner-five__single">
   <div class="banner-five__wrap">

      <?php if($image_url){ ?>
         <div class="banner-five__image">
            <img src="<?php echo esc_url($image_url) ?>" alt="<?php echo esc_html($banner['title']) ?>" />
         </div>
      <?php } ?>

      <div class="banner-five__content-inner">
         <?php 
            if($has_icon){ 
               echo '<span class="banner-five__icon">';
                  Icons_Manager::render_icon($banner['icon'], ['aria-hidden' => 'true']); 
               echo '</span>';
            } 
            if($banner['title']){ 
               echo '<h3 class="banner-five__title">';
                  echo $banner['title'];
               echo '</h3>';
            }
            if ( $settings['show_number_content'] == 'yes' && $term_count ) {
               if(!empty($banner['term_slug'])){
                  echo '<div class="banner-five__number">' . sprintf(_n('%d Listing', '%d Listings', $term_count, 'homirx-themer'), $term_count) . '</div>';
               }
            }
         ?>
      </div>

      <?php 
         if($link_term){ 
            echo '<span class="banner-five__arrow"><i class=" hicon-arrow-right-1"></i></span>';
            echo '<a class="banner-five__overlay" href="' . esc_url($link_term) . '" '. $target . '></a>';
         } 
      ?>
      
   </div>
</div>