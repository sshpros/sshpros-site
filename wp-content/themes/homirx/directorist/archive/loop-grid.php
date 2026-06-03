<?php
/**
 * @author  wpWax
 * @since   6.6
 * @version 6.7
 */

if ( ! defined( 'ABSPATH' ) ) exit;

$loop_fields = $listings->loop['card_fields']['template_data']['grid_view_with_thumbnail'];
?>

<div class="property-block listing-has-thumb <?php echo esc_attr( $listings->loop_wrapper_class() ); ?>">

	<div class="property-block__thumb">
		<?php
			$listings->loop_thumb_card_template();
			$listings->render_loop_fields($loop_fields['thumbnail']['avatar']);
		?>
		<div class="property-thumb-top-left"><?php $listings->render_loop_fields($loop_fields['thumbnail']['top_left']); ?></div>
		<div class="property-thumb-top-right"><?php $listings->render_loop_fields($loop_fields['thumbnail']['top_right']); ?></div>
		<div class="property-thumb-bottom-left"><?php $listings->render_loop_fields($loop_fields['thumbnail']['bottom_left']); ?></div>
		<div class="property-thumb-bottom-right"><?php $listings->render_loop_fields($loop_fields['thumbnail']['bottom_right']); ?></div>
	</div>

	<div class="property-block__content">

		<div class="property-block__info">
			<div class="property-block__info--top"><?php $listings->render_loop_fields($loop_fields['body']['top']); ?></div>
			<div class="property-block__info--list"><?php $listings->render_loop_fields($loop_fields['body']['bottom']); ?></div>
			<div class="property-block__info--excerpt"><?php $listings->render_loop_fields($loop_fields['body']['excerpt']); ?></div>
		</div>

		<div class="property-block__meta">
			<div class="property-block__meta--left"><?php $listings->render_loop_fields($loop_fields['footer']['left']); ?></div>
			<div class="property-block__meta--right"><?php $listings->render_loop_fields($loop_fields['footer']['right']); ?></div>
		</div>

	</div>

</div>