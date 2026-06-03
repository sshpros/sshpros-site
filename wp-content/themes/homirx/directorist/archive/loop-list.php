<?php
/**
 * @author  wpWax
 * @since   6.6
 * @version 6.7
 */

if ( ! defined( 'ABSPATH' ) ) exit;

$loop_fields = $listings->loop['list_fields']['template_data']['list_view_with_thumbnail'];
?>

<div class="property-list listing-list listing-has-thumb <?php echo esc_attr( $listings->loop_wrapper_class() ); ?>">

	<div class="property-list__wrap">
		<div class="property-list__thumb">
			<?php $listings->loop_thumb_card_template(); ?>
			<div class="property-thumb-top-right"><?php $listings->render_loop_fields($loop_fields['thumbnail']['top_right']); ?></div>
		</div>

		<div class="property-list__content">
			<div class="property-list__info">
				<div class="property-list__info--top"><?php $listings->render_loop_fields($loop_fields['body']['top']); ?></div>
				<div class="property-list__info--list"><?php $listings->render_loop_fields($loop_fields['body']['bottom'], '<div>', '</div>'); ?></div>
				<div class="property-list__info--excerpt"><?php $listings->render_loop_fields($loop_fields['body']['excerpt']); ?></div>
				<div class="property-list__info--right"><?php $listings->render_loop_fields($loop_fields['body']['right']); ?></div>
			</div>
			<div class="property-list__meta">
				<div class="property-list__meta--left"><?php $listings->render_loop_fields($loop_fields['footer']['left']); ?></div>
				<div class="property-list__meta--right"><?php $listings->render_loop_fields($loop_fields['footer']['right']); ?></div>
			</div>
		</div>
	</div>	

</div>