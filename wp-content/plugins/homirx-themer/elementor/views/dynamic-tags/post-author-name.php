<?php
   if (!defined('ABSPATH')) {
      exit; 
   }
   global $homirx_post;
   if (!$homirx_post){
      return;
   }
   ?>
   
   <div class="post-author-name">
      <?php 
         $author_id = get_post_field('post_author', $homirx_post->ID);
         $author = get_user_by('id', $author_id);
      ?>
      <a href="<?php echo get_author_posts_url($author_id) ?>">
         <?php 
            if($settings['show_icon']){ 
               echo '<i class="far fa-user"></i>';
            }
            echo esc_html($author->display_name);
         ?>
      </a>
   </div>      

