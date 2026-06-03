<?php
  use Elementor\Icons_Manager;

   $style = $settings['style'];
   $description_text = $settings['description_text'];
   $header_tag = 'h2';
   if(!empty($settings['header_tag'])) $header_tag = $settings['header_tag'];

   $has_icon = (!empty( $settings['selected_icon']['value'])) ? true : false;
   $title_html = $settings['title_text'];

   $this->add_render_attribute( 'block', 'class', [ 'widget gsc-icon-box-styles', $settings['style'], $settings['active'] == 'yes' ? 'active' : '' ] );
   $this->add_render_attribute( 'description_text', 'class', 'desc' );
   $this->add_render_attribute( 'title_text', 'class', 'title' );

   $this->add_inline_editing_attributes( 'title_text', 'none' );
   $this->add_inline_editing_attributes( 'description_text' );

?>

   <?php if($style == 'style-1'){ ?>
      <div class="box-style-one__single">
         <div class="box-style-one__content">
           
            <?php if ( $has_icon ){ ?>
               <div class="box-style-one__icon-inner">
                  <span class="icon">
                     <?php Icons_Manager::render_icon( $settings['selected_icon'], [ 'aria-hidden' => 'true' ] ); ?>
                  </span>
               </div>
            <?php } ?>

            <div class="box-style-one__content-inner">
               <?php 
                  if(!empty($settings['title_text'])){
                     echo '<' . esc_attr($header_tag) . ' class="box-style-one__title">';
                        echo $title_html;
                     echo '</' . esc_attr($header_tag) . '>';
                  } 
                  if(!empty($settings['description_text'])){ 
                     echo '<div class="box-style-one__desc">' . wp_kses($description_text, true) . '</div>';
                  } 
               ?>
            </div>
         </div> 
         <?php $this->gva_render_link_html('', $settings['button_url'], 'box-style-one__link-overlay'); ?>
      </div> 
      
   <?php } ?>

   <?php if($style == 'style-2'){ ?>
      <div class="box-style-two__single">
         <div class="box-style-two__wrap">
            <div class="box-style-two__icon-wrap">
               <?php 
                  echo '<span class="box-style-two__icon">';
                     if($has_icon){ 
                        Icons_Manager::render_icon( $settings['selected_icon'], [ 'aria-hidden' => 'true' ] );
                     }
                  echo '</span>';
               ?>
            </div>
            <div class="box-style-two__content">
               <?php 
                  if(!empty($settings['title_text'])){ 
                     echo '<' . esc_attr($header_tag) . ' class="box-style-two__title">';
                        echo $title_html;
                     echo '</' . esc_attr($header_tag) . '>';
                  } 
                  if(!empty($settings['description_text'])){ 
                     echo '<div class="box-style-two__desc">';
                        echo wp_kses($description_text, true);
                     echo '</div>';
                  }
               ?>
            </div>
         </div> 
         <span class="box-style-two__arrow"><i class="hicon-right-arrow"></i></span>
         <?php $this->gva_render_link_html('', $settings['button_url'], 'link-overlay'); ?>
      </div>  
   <?php } ?>


   <?php if($style == 'style-3'){ ?>
      <div class="box-style-three__single">
         <div class="box-style-three__content">
            <div class="box-style-three__icon-wrap">
               <?php 
                  echo '<span class="box-style-three__icon">';
                     if($has_icon){ 
                        Icons_Manager::render_icon( $settings['selected_icon'], [ 'aria-hidden' => 'true' ] );
                     }
                  echo '</span>';

                  if(!empty($settings['title_text'])){ 
                     echo '<' . esc_attr($header_tag) . ' class="box-style-three__title">';
                        echo $title_html;
                     echo '</' . esc_attr($header_tag) . '>';
                  } 
               ?>
            </div>
            <?php 
               if(!empty($settings['description_text'])){ 
                  echo '<div class="box-style-three__desc">';
                     echo wp_kses($description_text, true);
                  echo '</div>';
               }
            ?>
         </div> 
         <?php $this->gva_render_link_html('', $settings['button_url'], 'link-overlay'); ?>
      </div>   
   <?php } ?>