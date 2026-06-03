<?php
/**
 * @author  wpWax
 * @since   8.0
 * @version 8.0
 */

if ( ! defined( 'ABSPATH' ) ) exit;
$id = $listing->id;
$address = get_post_meta( $id, '_address', true );
//Field name - placeholderKey - placeholderKey
$display_title = $listing->listing_header( 'title', 'quick-widgets-placeholder', 'quick-info-placeholder' );

?>

<h2 class="directorist-listing-details__listing-title"><?php echo esc_html( $listing->get_title() ); ?></h2>

<?php 
	if ( $display_tagline && $listing->get_tagline() ){
	   echo '<p class="directorist-listing-details__tagline">' . esc_html( $listing->get_tagline() ) . '</p>';
	}
	
	if ( isset($display_title['enable_address']) && $display_title['enable_address'] && $address ){
	   echo '<p class="directorist-listing-details__tagline"><i class="hicon-maps-and-flags"></i>' . esc_html( $address ) . '</p>';
	}
?>

<?php do_action( 'directorist_single_listing_after_title', $listing->id ); ?>