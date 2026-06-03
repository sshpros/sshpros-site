<?php
/**
 *
 * @author     Gaviasthemes Team     
 * @copyright  Copyright (C) 2024 Gaviasthemes. All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 * 
 */

$dashboard_pid = get_option( 'job_manager_job_dashboard_page_id');
$submit_form_page = get_option( 'job_manager_submit_job_form_page_id', false );
$post_id = get_the_ID();
if($dashboard_pid != $post_id){
   get_header();
}
?>
<section id="wp-main-content" class="clearfix main-page">
   <?php do_action('homirx_before_page_content'); ?>
   <div class="main-page-content">
      <div class="content-page">      
         <div id="wp-content" class="wp-content clearfix">
            <?php 
               
               if(class_exists('Tribe__Events__Main') && (tribe_is_event() || tribe_is_event_category() || tribe_is_in_main_loop() || tec_is_view() || 'tribe_events' == get_post_type() || is_singular( 'tribe_events' ))) {
                  get_template_part('/tribe-events/single');
               }
               elseif(is_archive('tribe_event')){
                  get_template_part('/tribe-events/archive');
               }
               else{
                  get_template_part('templates/page/single');
               }
               
            ?>
         </div>    
      </div>      
   </div>   
   <?php do_action('homirx_after_page_content'); ?>
</section>

<?php 
   if($dashboard_pid != get_the_ID()){
      get_footer(); 
   }
?>