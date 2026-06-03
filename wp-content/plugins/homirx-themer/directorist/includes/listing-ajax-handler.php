<?php
use \Directorist\Helper;

class Listing_Ajax_Handler {
   // instant search
   public function __construct() {
      add_action( 'wp_ajax_directorist_type_tab', array( $this, 'listing_type_tab' ) );
      add_action( 'wp_ajax_nopriv_directorist_type_tab', array( $this, 'listing_type_tab' ) );
   }
   public function listing_type_tab() {
      if ( empty( $_POST['_nonce'] ) || ! wp_verify_nonce( wp_unslash( $_POST['_nonce'] ), 'bdas_ajax_nonce' ) ) { // @codingStandardsIgnoreLine.WordPress.Security.ValidatedSanitizedInput.InputNotSanitized
         wp_send_json(
            array(
               'search_result'  => esc_html__( 'Something went wrong, please try again.', 'homirx-themer' ),
               'directory_type' => '',
               'count'          => '',
            )
         );
      }

      $args = array();

      if ( ! empty( $_POST['data_atts'] ) ) {
         $args = directorist_clean( (array) wp_unslash( $_POST['data_atts'] ) );
      }

      // if ( ! empty( $args['ids'] ) && ! isset( $_REQUEST['ids'] ) ) {
      //    $_REQUEST['ids'] = $args['ids'];
      //    $_POST['ids']    = $args['ids'];
      // }

      $listings = new Directorist\Directorist_Listings( $args );
      ob_start();
      //$listings->archive_view_template();

      if( !empty($args['layout']) && $args['layout'] == 'grid' ){ ?>
         <?php 
            if($listings->have_posts()){
               foreach( $listings->post_ids() as $listing_id ){
                  echo '<div class="item-columns">';
                     $listings->loop_template( $args['property_layout'], $listing_id );
                  echo '</div>';
               }
            }else{
               echo '<div class="directorist-archive-notfound">' . esc_html__( 'No listings found.', 'homirx-themer' ) . '</div>';
            }
         ?>
      <?php } ?>

      <?php if( !empty($args['layout']) && $args['layout'] == 'carousel' ){ ?>
            <?php if($listings->have_posts()){ ?>
               <div class="swiper-slider-wrapper">
                  <div class="swiper-content-inner">
                     <div class="init-carousel-swiper swiper">
                        <div class="swiper-wrapper">
                           <?php
                              foreach( $listings->post_ids() as $listing_id ){
                                 echo '<div class="swiper-slide">';
                                    $listings->loop_template( $args['property_layout'], $listing_id );
                                 echo '</div>';
                              }
                           ?>
                        </div>
                     </div>      
                  </div>
                  <?php echo ($args['carousel']['ca_pagination'] ? '<div class="swiper-pagination"></div>' : '' ); ?>
                  <?php echo ($args['carousel']['ca_navigation'] ? '<div class="swiper-nav-next"></div><div class="swiper-nav-prev"></div>' : '' ); ?> 
               </div>
            <?php 
               }else{
                  echo '<div class="directorist-archive-notfound">' . esc_html__( 'No listings found.', 'homirx-themer' ) . '</div>';
               }
            ?>
      <?php } ?>

      <?php
      $archive_view = ob_get_clean();
      wp_send_json(
         array(
            'search_result'  => $archive_view,
            //'directory_type' => $listings->render_shortcode(),
            'count'          => $listings->query_results->total,
         )
      );
   }

}

new Listing_Ajax_Handler();