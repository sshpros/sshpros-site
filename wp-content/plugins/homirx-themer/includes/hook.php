<?php
add_action('init','homirx_themer_disable_kses_if_allowed');
function homirx_themer_disable_kses_if_allowed() {
   if (current_user_can('unfiltered_html')) {
      // Disables Kses only for textarea saves
      foreach (array('pre_term_description', 'pre_link_description', 'pre_link_notes', 'pre_user_description') as $filter) {
         remove_filter($filter, 'wp_filter_kses');
      }
   }

   // Disables Kses only for textarea admin displays
   foreach (array('term_description', 'link_description', 'link_notes', 'user_description') as $filter) {
      remove_filter($filter, 'wp_kses_data');
   }
}

function homirx_themer_mime_types($mimes) {
   $mimes['svg'] = 'image/svg+xml';
   return $mimes;
}
add_filter('upload_mimes', 'homirx_themer_mime_types');


// Disables the block editor from managing widgets in the Gutenberg plugin.
add_filter( 'gutenberg_use_widgets_block_editor', '__return_false' );
// Disables the block editor from managing widgets.
add_filter( 'use_widgets_block_editor', '__return_false' );

add_filter('wpcf7_autop_or_not', '__return_false');

add_filter( 'wpjm_get_job_listing_structured_data', '__return_false' );

add_filter( 'wp_img_tag_add_auto_sizes', 'homirx_themer_disable_auto_size' );
function homirx_themer_disable_auto_size(){
	return false;
}
add_filter('atbdp_setup_wizard', 'homirx_themer_disable_directorist_import');
function homirx_themer_disable_directorist_import(){
	return false;
}