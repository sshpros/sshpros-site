<?php
/**
 * @author  wpWax
 * @since   6.6
 * @version 6.7
 */

if ( ! defined( 'ABSPATH' ) ) exit;

$loop_fields = $listings->loop['card_fields']['template_data']['grid_view_without_thumbnail'];
?>

<div class="property-listing-single property-card property-no-thumb <?php echo esc_attr( $listings->loop_wrapper_class() ); ?>">

	<div class="property-card__header">

		<div class="property-card__header__left">
			<?php $listings->render_loop_fields($loop_fields['body']['avatar']); ?>

			<div class="property-card__title"><?php $listings->render_loop_fields($loop_fields['body']['title']); ?></div>
		</div>

		<div class="property-card__header__right">
			<div class="property-card__action"><?php $listings->render_loop_fields($loop_fields['body']['quick_actions']); ?></div>
		</div>
		
	</div>

	<div class="property-card__info"><?php $listings->render_loop_fields($loop_fields['body']['quick_info']); ?></div>

	<div class="property-card__content">

		<div class="property-card__content__body">
			<div class="property-card__info--list"><ul><?php $listings->render_loop_fields($loop_fields['body']['bottom'], '<li>', '</li>'); ?></ul></div>
			<div class="property-card__info--excerpt"><?php $listings->render_loop_fields($loop_fields['body']['excerpt']); ?></div>
		</div>

		<div class="property-card__meta">
			<div class="property-card__meta--left"><?php $listings->render_loop_fields($loop_fields['footer']['left']); ?></div>
			<div class="property-card__meta--right"><?php $listings->render_loop_fields($loop_fields['footer']['right']); ?></div>
		</div>

	</div>

</div>