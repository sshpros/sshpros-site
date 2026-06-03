<?php
   if (!defined('ABSPATH')) {
      exit; 
   }
   global $homirx_post;
   if (!$homirx_post){
      return;
   }
   $html_tag = $settings['html_tag'];
?>

<div class="homirx-post-title">
   <<?php echo esc_attr($html_tag) ?> class="post-title">
      <span><?php echo get_the_title($homirx_post) ?></span>
   </<?php echo esc_attr($html_tag) ?>>
</div>   