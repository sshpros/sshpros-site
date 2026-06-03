<?php
/**
 * @author  wpWax
 * @since   6.6
 * @version 8.0
 */

use \Directorist\Directorist_Single_Listing;

if ( ! defined( 'ABSPATH' ) ) exit;

$listing = Directorist_Single_Listing::instance();

$id = $listing->id;

//Field name - placeholderKey - placeholderKey
$display_title = $listing->listing_header( 'lt_title', 'quick-widgets-placeholder', 'quick-info-placeholder' );
?>

<div class="property-top">
	<div class="property-top__wrap">
		<div class="property-top__left">
			<?php if( $listing->display_back_link() ): ?>
				<a href="javascript:history.back()" class="directorist-single-listing-action directorist-return-back directorist-btn__back directorist-btn directorist-btn-sm directorist-btn-light"><?php directorist_icon( 'las la-arrow-left' ); ?> <span class="directorist-single-listing-action__text"><?php esc_html_e( 'Go Back', 'homirx'); ?></span> </a>
			<?php endif; ?>

			<?php 
				if($display_title){
					$address = get_post_meta( $id, '_address', true );
					echo '<h2 class="property-top__title">' . esc_html( $listing->get_title() ) . '</h2>';
					if ( $display_title['enable_tagline'] && $listing->get_tagline() ){
					   echo '<div class="property-top__tagline">' . esc_html( $listing->get_tagline() ) . '</div>';
					}
					if ( isset($display_title['enable_address']) && $display_title['enable_address'] && $address ){
					   echo '<div class="property-top__tagline"><i class="hicon-maps-and-flags"></i>' . esc_html( $address ) . '</div>';
					}
				}
			?>
		</div>

		<div class="property-top__right directorist-single-listing-quick-action">

			<?php if ( $listing->submit_link() ): ?>
				<div class="directorist-single-listing-top__btn-wrapper">
					<a href="<?php echo esc_url( $listing->submit_link() ); ?>" class="directorist-single-listing-action directorist-btn directorist-btn-sm directorist-btn-light directorist-single-listing-top__btn-continue"><span class="directorist-single-listing-action__text"><?php esc_html_e( 'Continue to Publish', 'homirx' ); ?></span> </a>
				</div>
			<?php endif; ?>
			
			<?php if ( $listing->current_user_is_author() ): ?>
				<a href="<?php echo esc_url( $listing->edit_link() ) ?>" class="directorist-single-listing-action directorist-btn directorist-btn-sm directorist-btn-light directorist-single-listing-top__btn-edit">
					<?php directorist_icon( 'las la-pen' ); ?>
					<span class="directorist-single-listing-action__text"><?php esc_html_e( 'Edit', 'homirx' ); ?></span>	
				</a>
			<?php endif; ?>

			<?php $listing->quick_actions_template(); ?>

		</div>
	</div>
</div>