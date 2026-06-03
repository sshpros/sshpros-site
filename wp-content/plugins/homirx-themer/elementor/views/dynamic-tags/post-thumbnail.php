<?php
   if (!defined('ABSPATH')) {
      exit; 
   }
   global $homirx_post;
   if (!$homirx_post){
      return;
   }
?>

<?php 
   $thumbnail_size = $settings['homirx_image_size'];

   if(has_post_thumbnail($homirx_post)){
      echo get_the_post_thumbnail($homirx_post, $thumbnail_size);
   }
?>

