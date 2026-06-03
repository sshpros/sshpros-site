<?php
   if (!defined('ABSPATH')) {
      exit; 
   }
   global $homirx_post;
   if (!$homirx_post){
      return;
   }
   ?>
   
   <div class="post-date">
         <?php 
            if($settings['show_icon']){ 
               echo '<i class="far fa-calendar"></i>';
            }
            echo get_the_date( get_option('date_format'), $homirx_post->ID);
         ?>
   </div>      

