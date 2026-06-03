<?php
   if (!defined('ABSPATH')){ exit; }

   global $homirx_post, $post;

   if(!$homirx_post){ return; }
   $post = $homirx_post;
?>
   
<div class="post-comment">
   <?php
      if(comments_open($homirx_post->ID)){
         comments_template();
      }else{
         if(\Elementor\Plugin::$instance->editor->is_edit_mode()){
            echo '<div class="alert alert-info">' . esc_html__('This Post Disabled Comment', 'homirx-themer') . '</div>';
         }
      }
   ?>
</div>      

