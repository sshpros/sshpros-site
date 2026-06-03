<?php 
   if (!defined('ABSPATH')){ exit; }
	use Elementor\Icons_Manager;
   use Elementor\Group_Control_Image_Size;
	$has_icon = !empty($item['selected_icon']['value']);
   $style = $settings['style'];

   $this->add_render_attribute('wrapper', 'class', ['el-image-accordion']);

?>

<div <?php echo $this->get_render_attribute_string('wrapper'); ?>>
   <div class="images-accordion-wrap">
      <?php
         foreach ($settings['services_content'] as $item){

         	$term_count = 0;
         	$term_count_html = '';
         	$link = '';
         	if(class_exists('ATBDP_Listing')){
				   $taxonomy = $item['taxonomy'] ? $item['taxonomy'] : 'at_biz_dir-location'; 
				   $term  = false;
				   if( !empty($item['term_slug']) ){
				      $term = get_term_by( 'slug', $item['term_slug'], $taxonomy );
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
				   //$link = $link_term;
				   if($term_count){
				   	$term_count_html = $term_count . ' ' . ($term_count == '1' ? esc_html__('Property', 'homirx-themer') : esc_html__('Properties', 'homirx-themer'));
				   }
				}

            $active_class = $item['active'] == 'yes' ? ' active default-active' : '';
         	$image_id = $item['image']['id']; 
            $image_url = isset($item['image']['url']) ? $item['image']['url'] : '';
            if($image_id){
               $attach_url = Group_Control_Image_Size::get_attachment_image_src($image_id, 'image', $settings);
               if($attach_url){
                  $image_url = $attach_url;
               }
            }
            
      ?> 
         <div class="image-accordion-item<?php echo esc_attr($active_class) ?>">
            <?php 
               if($image_url){ 
                  echo '<div class="accordion-one__image">';
                     echo '<img src="' . esc_url($image_url) . '" alt="' . esc_html($item['title']) . '"/>';
                  echo '</div>';
               }
            ?>
            <div class="accordion-one__single">
               <div class="accordion-one__content">
         			<div class="accordion-one__content-inner">
                     <?php 
                     	if($term_count_html){
            					echo '<div class="accordion-one__count"><span>' . esc_html($term_count_html) . '</span></div>';
                     	}
            				if($item['title']){
            					echo '<h4 class="accordion-one__title"><span>' . esc_html($item['title']) . '</span></h4>';
            				}
            				if($item['desc']){
            					echo '<div class="accordion-one__desc">' . $item['desc']  . '</div>';
            				}
                     ?>
         			</div>
                  <?php 
                     if(isset($item['link']['url']) && $item['link']['url']){
                        echo '<div class="accordion-one__button">';
                           echo '<a href="' . esc_url($item['link']['url']) . '"><i class="hicon-arrow-1"></i></a>'; 
                        echo '</div>';
                     }
                     echo $this->gva_render_link_overlay($item['link'], 'accordion-one__link-overlay'); 
                  ?>
                  <a class="accordion-one__mobile-control" href="#"><i class="fas fa-expand-alt"></i></a>
         	   </div>
            </div>
      	</div>
      <?php } ?> 
   </div>
</div>