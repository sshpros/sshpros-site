<?php
   use Elementor\Group_Control_Image_Size;

   $desc = $settings['desc'];
   $title_text = $settings['title'];

   $this->add_render_attribute( 'title_text', 'class', 'title' );
   $image_id = $settings['image']['id']; 
   $image_url = $settings['image']['url'];

   if($image_id){
      $attach_url = Group_Control_Image_Size::get_attachment_image_src($image_id, 'image', $settings);
      if($attach_url) $image_url = $attach_url;
   }

   $term_count = 0;
	$term_count_html = '';
	if(class_exists('ATBDP_Listing')){
	   $taxonomy = $settings['taxonomy'] ? $settings['taxonomy'] : 'at_biz_dir-location'; 
	   $term = false;
	   if( !empty($settings['term_slug']) ){
	      $term = get_term_by( 'slug', $settings['term_slug'], $taxonomy );
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
	   	$term_count_html = $term_count . '&nbsp;' . ($term_count == '1' ? $settings['show_number_one_text'] : $settings['show_number_text']);
	   }
	}


?>

<?php if($settings['style'] == 'style-1'){ ?>
   <div class="banner-one__single active-<?php echo esc_attr($settings['item_active']) ?>">
      <div class="banner-one__wrap">
         <?php if($image_url){ ?>
            <div class="banner-one__image">
               <img src="<?php echo esc_url($image_url) ?>" alt="<?php echo esc_html($title_text) ?>" />
            </div>
         <?php } ?>

         <div class="banner-one__content">
            <?php 
               if($title_text){
                  echo '<div class="banner-one__title-wrap">';
                     if ( $settings['show_number_content'] == 'yes' && $term_count ) {
                        echo '<span class="banner-one__count">';
                           echo $term_count_html;
                        echo '</span>';
                     }
                     echo '<h3 class="banner-one__title">' . $title_text . '</h3>';
                  echo '</div>';   
               } 
               if($desc){
                  echo '<div class="banner-one__desc">' . esc_html($desc) . '</div>';
               } 
            ?>
         </div>

         <div class="banner-one__content-hover">
            <?php 
               if ( $settings['show_number_content'] == 'yes' && $term_count ) {
                  echo '<span class="banner-one__hover-count">';
                     echo $term_count . '&nbsp;';
                     echo ($term_count < 2 ? $settings['show_number_one_text'] : $settings['show_number_text']);
                  echo '</span>';
               }
               if($title_text){
                  echo '<h3 class="banner-one__hover-title">' . $title_text . '</h3>';
               } 
            ?>
         </div>
         <?php $this->gva_render_link_html('', $settings['link'], 'banner-one__link-overlay'); ?>
      </div>   
   </div>
<?php } ?>
