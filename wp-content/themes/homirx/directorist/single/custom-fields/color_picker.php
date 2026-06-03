<?php
/**
 * @author  wpWax
 * @since   6.7
 * @version 7.0.5.2
 */

if ( ! defined( 'ABSPATH' ) ) exit;
?>

<div class="property-single-info property-single-info-picker">
	<div class="property-single-info__left">
		<?php if($icon){ ?>
			<span class="property-single-info__icon"><?php directorist_icon( $icon );?></span>
		<?php } ?>
	</div>
	<div class="property-single-info__right">
		<div class="property-single-info__label"><?php echo esc_html( $data['label'] ); ?></span>
		<div class="property-single-info__value"><?php echo esc_html( $value ); ?>
			<div class="directorist-field-type-color" style="background-color:<?php echo esc_html( $value ); ?>"></div>
		</div>
	</div>
</div>