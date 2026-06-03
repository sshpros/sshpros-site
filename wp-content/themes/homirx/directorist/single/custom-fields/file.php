<?php
/**
 * @author  wpWax
 * @since   6.6
 * @version 7.3.1
 */

if ( ! defined( 'ABSPATH' ) ) exit;

$done = str_replace( '|||', '', $value );
$name_arr = explode( '/', $done );
$filename = end( $name_arr );
?>

<div class="property-single-info property-single-info-file">
	<div class="property-single-info__left">
		<?php if($icon){ ?>
			<span class="property-single-info__icon"><?php directorist_icon( $icon );?></span>
		<?php } ?>
	</div>
	<div class="property-single-info__right">
		<span class="property-single-info__label"><?php echo esc_html( $data['label'] ); ?></span>
		<span class="property-single-info__value"><?php printf('<a href="%s" target="_blank" download>%s</a>', esc_url( $done ), esc_html( $filename ) ); ?></span>
	</div>
</div>