<?php
/**
 * @author  wpWax
 * @since   6.7
 * @version 7.0.5.2
 */

if ( ! defined( 'ABSPATH' ) ) exit;
?>

<div class="property-single-info property-single-info-email">

	<?php if($icon){ ?>
		<div class="property-single-info__left">
			<span class="property-single-info__icon"><?php directorist_icon( $icon );?></span>
		</div>
	<?php } ?>

	<div class="property-single-info__right">
		<span class="property-single-info__label"><?php echo esc_html( $data['label'] ); ?></span>
		<span class="property-single-info__value">
			<a target="_top" href="mailto:<?php echo esc_attr( $value ); ?>"><?php echo esc_html( $value ); ?></a>
		</span>
	</div>

</div>