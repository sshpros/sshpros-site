<?php
use Directorist\Directorist_Listings;
use Directorist\Helper;
if ( ! defined( 'ABSPATH' ) ) exit;

function homirx_themer_loop_template( $listings, $loop = 'grid', $id = NULL ) { // Temp function
   if ( ! $id ) {
      return;
   }

   _prime_post_caches( $listings->post_ids() );

   global $post;
   $post = get_post( $id );
   setup_postdata( $post );

   $listings->set_loop_data();

   if ( $loop == 'grid' && !empty( $listings->loop['card_fields'] ) ) {
      $active_template = $listings->loop['card_fields']['active_template'];
      $template = ( $active_template == 'grid_view_with_thumbnail' && $listings->display_preview_image ) ? 'loop-grid' : 'loop-grid-nothumb';
      Helper::get_template( 'archive/' . $template, array( 'listings' => $listings ) );
   }
   elseif ( $loop == 'list' && !empty( $listings->loop['list_fields'] ) ) {
      $active_template = $listings->loop['list_fields']['active_template'];
      $template = ( $active_template == 'list_view_with_thumbnail' && $listings->display_preview_image ) ? 'loop-list' : 'loop-list-nothumb';
      Helper::get_template( 'archive/' . $template, array( 'listings' => $listings ) );
   }elseif($loop == 'grid-02' && !empty( $listings->loop['card_fields'] )){
      $template = 'loop-grid-02';
      Helper::get_template( 'archive/' . $template, array( 'listings' => $listings ) );
   }
   wp_reset_postdata();
}
