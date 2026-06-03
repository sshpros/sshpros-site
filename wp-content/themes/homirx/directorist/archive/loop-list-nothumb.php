<?php
/**
 * @author  wpWax
 * @since   6.6
 * @version 6.7
 */

if ( ! defined( 'ABSPATH' ) ) exit;

$loop_fields = $listings->loop['list_fields']['template_data']['list_view_without_thumbnail'];
?>

<div class="property-list directorist-listing-card directorist-listing-card--list directorist-listing-no-thumb <?php echo esc_attr( $listings->loop_wrapper_class() ); ?>">

	<div class="property-list__header">

		<div class="property-list__header__left">
			<div class="property-list__info"><?php $listings->render_loop_fields($loop_fields['body']['top']); ?></div>
		</div>
		
		<div class="property-list__header__right">
			<div class="property-list__action"><?php $listings->render_loop_fields($loop_fields['body']['right']); ?></div>
		</div>

	</div>

	<div class="property-list__content">

		<div class="property-list__content__body">
			<div class="property-list__info--list"><ul><?php $listings->render_loop_fields($loop_fields['body']['bottom'], '<li>', '</li>'); ?></ul></div>
			<div class="property-list__info--excerpt"><?php $listings->render_loop_fields($loop_fields['body']['excerpt']); ?></div>
		</div>

		<div class="property-list__meta">
			<div class="property-list__meta--left">
				<?php $listings->render_loop_fields($loop_fields['footer']['left']); ?>
			</div>
			<div class="property-list__meta--right">
				<?php $listings->render_loop_fields($loop_fields['footer']['right']); ?>
			</div>
		</div>

	</div>
	
</div>