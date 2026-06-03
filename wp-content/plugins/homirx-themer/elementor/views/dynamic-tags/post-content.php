<?php
   if (!defined('ABSPATH')) {
      exit; 
   }
   global $homirx_post;
   if (!$homirx_post){
      return;
   }
   ?>
   
   <div class="post-content">
      <?php 
      if(\Elementor\Plugin::$instance->editor->is_edit_mode()){
         echo do_shortcode( $homirx_post->post_content );
      }else{
         $content = apply_filters( 'the_content', $homirx_post->post_content );
         echo do_shortcode($content);
      }
      ?>
   </div> 