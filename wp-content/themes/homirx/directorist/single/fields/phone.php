<?php
/**
 * @author  wpWax
 * @since   6.7
 * @version 7.0.6
 */

use \Directorist\Helper;

if ( ! defined( 'ABSPATH' ) ) exit;

$phone_args = array(
	'number'    => $value,
	'whatsapp'  => $listing->has_whatsapp( $data ),
);

?>

<div class="property-single-info property-single-info-phone">

	<?php if($icon){ ?>
		<div class="property-single-info__left">
			<span class="property-single-info__icon"><?php directorist_icon( $icon );?></span>
		</div>
	<?php } ?>

	<div class="property-single-info__right">
		<span class="property-single-info__label"><?php echo esc_html( $data['label'] ); ?></span>
		<span class="property-single-info__value">
			<a href="<?php echo esc_url( Helper::phone_link( $phone_args ) ); ?>"><?php echo esc_html( $value ); ?></a>
		</span>
	</div>

</div>