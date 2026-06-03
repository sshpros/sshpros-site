<?php
/**
 * @author  wpWax
 * @since   6.7
 * @version 7.0.5.2
 */

if ( ! defined( 'ABSPATH' ) ) exit;
?>

<div class="property-single-info property-single-info-web">

	<?php if($icon){ ?>
		<div class="property-single-info__left">
			<span class="property-single-info__icon"><?php directorist_icon( $icon );?></span>
		</div>
	<?php } ?>

	<div class="property-single-info__right">
		<span class="property-single-info__label"><?php echo esc_html( $data['label'] ); ?></span>
		<span class="property-single-info__value">
			<a target="_blank" href="<?php echo esc_url( $value ); ?>"<?php echo !empty( $data['use_nofollow'] ) ? 'rel="nofollow"' : ''; ?>><?php echo esc_html( $value ); ?></a>
		</span>
	</div>

</div>