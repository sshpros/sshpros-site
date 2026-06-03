<?php
   if (!defined('ABSPATH')) {
      exit; 
   }
   global $homirx_post;
   if (!$homirx_post){
      return;
   }

   $title = $settings['title_text'];
   $posttags = get_the_tags($homirx_post->ID);
?>
   
<div class="post-tags">
   <?php 
      if($posttags){ 
         if($title){
            echo '<span class="title">' . esc_html($title) . ':</span>';
         }
         foreach($posttags as $tag){
            echo '<a href="' . esc_url(get_term_link($tag->term_id)) . '">';
               echo $tag->name;
            echo '</a>';
         }
      }
   ?>
</div>      

