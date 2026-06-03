<?php
/**
 * @author  wpWax
 * @since   6.6
 * @version 7.0.5.2
 */

if ( ! defined( 'ABSPATH' ) ) exit;

$value = $listing->get_custom_field_value( 'select', $data );
?>

<div class="property-single-info property-single-info-select">
	<div class="property-single-info__left">
		<?php if($icon){ ?>
			<span class="property-single-info__icon"><?php directorist_icon( $icon );?></span>
		<?php } ?>
	</div>
	<div class="property-single-info__right">
		<span class="property-single-info__label"><?php echo esc_html( $data['label'] ); ?></span>
		<span class="property-single-info__value"><?php echo esc_html( $value ); ?></span>
	</div>
</div>