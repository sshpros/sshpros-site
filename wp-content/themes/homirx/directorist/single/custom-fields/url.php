<?php
/**
 * @author  wpWax
 * @since   6.7
 * @version 7.10.0
 */

if ( ! defined( 'ABSPATH' ) ) exit;
?>

<div class="property-single-info property-single-info-url">
	<div class="property-single-info__left">
		<?php if($icon){ ?>
			<span class="property-single-info__icon"><?php directorist_icon( $icon );?></span>
		<?php } ?>
	</div>
	<div class="property-single-info__right">
		<span class="property-single-info__label"><?php echo esc_html( $data['label'] ); ?></span>
		<span class="property-single-info__value">
			<a <?php echo ! empty( $data['form_data']['target'] ) ? esc_attr( 'target="_blank"' ) : ''; ?> href="<?php echo esc_url( $value ); ?>" <?php echo !empty( $data['use_nofollow'] ) ? 'rel="nofollow"' : ''; ?>><?php echo esc_html( $value ); ?></a>
		</span>
	</div>
</div>