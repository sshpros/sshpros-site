<?php
/**
 * @author  wpWax
 * @since   6.7
 * @version 7.0.5.2
 */

if ( ! defined( 'ABSPATH' ) ) exit;
?>
<?php if(isset($value) && !empty(trim($value))){ ?>
<div class="property-single-info property-single-info-text">
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
<?php } ?>