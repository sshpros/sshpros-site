<?php
   use Elementor\Group_Control_Image_Size;

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

   $classes = array();
   $classes = $banner['item_active'] == 'yes' ? 'banner-four__single banner-active' : 'banner-four__single';
?>

<div class="item">
   <div class="<?php echo esc_attr($classes) ?>">
      <div class="banner-four__wrap">
         <?php 
            if($image_url){
               echo '<div class="banner-four__image">';
                  echo '<img src="' . esc_url($image_url) . '" alt="' . esc_html($banner['title']) . '"/>';
                  if ( $settings['show_number_content'] == 'yes' && $term_count ) {
                     if(!empty($banner['term_slug'])){
                        echo '<div class="banner-four__number">' . sprintf(_n('%d Listing', '%d Listings', $term_count, 'homirx-themer'), $term_count) . '</div>';
                     }
                  }
               echo '</div>';
            } 
         ?>

         <div class="banner-four__content">
            <?php 
               if($banner['sub_title']){ 
                  echo '<div class="banner-four__subtitle">' . $banner['sub_title'] . '</div>';
               }
               if($banner['title']){
                  echo '<h3 class="banner-four__title">' . $banner['title'] . '</h3>';
               } 
            ?>        
         </div>
         
         <?php if($link_term){ ?>
            <a class="banner-four__link" href="<?php echo esc_url($link_term); ?>" <?php echo $target ?>></a>
         <?php } ?>
      </div>         
   </div>
</div>