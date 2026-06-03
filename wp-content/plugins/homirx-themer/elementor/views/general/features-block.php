<?php
   use Elementor\Icons_Manager;
   use Elementor\Group_Control_Image_Size;

   $style = $settings['style'];
   $title_html = $settings['title_text'];
   $description_text = $settings['description_text'];
   $header_tag = 'h2';
   if(!empty($settings['header_tag'])) $header_tag = $settings['header_tag'];
   $has_icon = ! empty( $settings['selected_icon']['value']);
   $classes = ($settings['active'] == 'yes') ? ' active' : '';
?>

<?php if($style == 'style-1'){ ?>
   <div class="feature-one__single<?php echo esc_attr($classes) ?>">
      <div class="feature-one__wrapper">
         <div class="feature-one__box-content">
            <?php 
               if ( $has_icon ){ 
                  echo '<div class="feature-one__icon-box">';
                     Icons_Manager::render_icon( $settings['selected_icon'], [ 'aria-hidden' => 'true' ] );
                  echo '</div>';
               } 
               if(!empty($settings['title_text'])){
                  echo '<' . esc_attr($header_tag) . ' class="feature-one__title">';
                     echo $title_html;
                  echo '</' . esc_attr($header_tag) . '>';
               } 
               if(!empty($settings['description_text'])){ 
                  echo '<div class="feature-one__desc">' . wp_kses($description_text, true) . '</div>';
               } 
            ?>
         </div>
         <div class="feature-one__bg">
            <div class="feature-one__bg-inner"></div>
         </div>
      </div> 
      <?php $this->gva_render_link_html('', $settings['button_url'], 'feature-one__link-overlay'); ?>
   </div>   
<?php } ?>


<?php 
   if($style == 'style-2'){
      echo '<div class="feature-two__single' . esc_attr($classes) . '">';
         echo '<div class="feature-two__wrapper">';
            if ($has_icon){ 
               echo '<div class="feature-two__icon">';
                  Icons_Manager::render_icon( $settings['selected_icon'], [ 'aria-hidden' => 'true' ] );
               echo '</div>';
            } 
            echo '<div class="feature-two__content">';
               if(!empty($settings['title_text'])){
                  echo '<' . esc_attr($header_tag) . ' class="feature-two__title">';
                     echo $title_html;
                  echo '</' . esc_attr($header_tag) . '>';
               } 
               if(!empty($settings['description_text'])){ 
                  echo '<div class="feature-two__desc">' . wp_kses($description_text, true) . '</div>';
               }
            echo '</div>'; 
         echo '</div>'; 
         $this->gva_render_link_html('', $settings['button_url'], 'feature-two__link'); 
      echo '</div>';   
   } 
?>

<?php 
   if($style == 'style-3'){
      echo '<div class="feature-three__single' . esc_attr($classes) . '">';
         echo '<div class="feature-three__wrapper">';
            if ($has_icon){ 
               echo '<div class="feature-three__icon">';
                  Icons_Manager::render_icon( $settings['selected_icon'], [ 'aria-hidden' => 'true' ] );
                  if($settings['number']){
                     echo '<span class="feature-three__number">' . $settings['number'] . '</span>';
                  }
               echo '</div>';
            } 
            echo '<div class="feature-three__content">';
               if(!empty($settings['title_text'])){
                  echo '<' . esc_attr($header_tag) . ' class="feature-three__title">';
                     echo $title_html;
                  echo '</' . esc_attr($header_tag) . '>';
               } 
               if(!empty($settings['description_text'])){ 
                  echo '<div class="feature-three__desc">' . wp_kses($description_text, true) . '</div>';
               }
            echo '</div>'; 
         echo '</div>'; 
         $this->gva_render_link_html('', $settings['button_url'], 'feature-three__link'); 
      echo '</div>';   
   } 
?>