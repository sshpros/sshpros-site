<?php
   use Elementor\Group_Control_Image_Size;

   $image_id = $banner['image']['id']; 
   $image_url = $banner['image']['url'];
   if($image_id){
      $attach_url = Group_Control_Image_Size::get_attachment_image_src($image_id, 'image', $settings);
      if($attach_url) $image_url = $attach_url;
   }
   $term_count = 0;
	$term_count_html = '';
	if(class_exists('ATBDP_Listing')){
	   $taxonomy = $banner['taxonomy'] ? $banner['taxonomy'] : 'at_biz_dir-location'; 
	   $term = false;
	   if( !empty($banner['term_slug']) ){
	      $term = get_term_by( 'slug', $banner['term_slug'], $taxonomy );
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
	   if($term_count){
	   	$term_count_html = $term_count . ' ' . ($term_count == '1' ? esc_html__('Property', 'homirx-themer') : esc_html__('Properties', 'homirx-themer'));
	   }
	}

	$link = $banner['link'];

?>

<div class="item">
   <div class="banner-three__single">
      <div class="banner-three__wrap">
         
         <?php 
            if($image_url){ 
               echo '<div class="banner-three__image">';
                  echo '<img src="' . esc_url($image_url) . '" alt="' . esc_html($banner['title']) . '"/>';
               echo '</div>';
            }  
         ?>
         <div class="banner-three__content">
            <div class="banner-three__content-inner">
               <?php
                  if ( $settings['show_number_content'] == 'yes' && $term_count ) {
                     if(!empty($banner['term_slug'])){
                        echo '<span class="banner-three__number">' . sprintf(_n('%d Listing', '%d Listings', $term_count, 'homirx-themer'), $term_count) . '</span>';
                     }
                  }
                  if($banner['sub_title']){ 
                     echo '<div class="banner-three__subtitle">' . $banner['sub_title'] . '</div>';
                  }
                  if($banner['title']){
                     echo '<h3 class="banner-three__title">' . $banner['title'] . '</h3>';
                  } 
               ?>
            </div>
            <?php 
            	if( isset($banner['link']['url']) && $banner['link']['url'] ){
         			$this->gva_render_link_html('<i class=" hicon-arrow-right-1"></i>', $link, 'banner-three__action');
            	}
         	?>
         </div>

         <?php 
         	$this->gva_render_link_html('', $link, 'banner-three__overlay');
         ?>
         
      </div>
   </div>   
</div>