<?php
/**
 * @author  wpWax
 * @since   6.7
 * @version 7.3.1
 */

if ( ! defined( 'ABSPATH' ) ) exit;

$address_data = $listing->get_address( $data );
$address = ( is_string( $address_data ) ) ? $address_data : '';
?>

<div class="property-single-info property-single-info-address">

	<?php if($icon){ ?>
		<div class="property-single-info__left">
			<span class="property-single-info__icon"><?php directorist_icon( $icon );?></span>
		</div>
	<?php } ?>

	<div class="property-single-info__right">
		<span class="property-single-info__label"><?php echo esc_html( $data['label'] ); ?></span>
		<span class="property-single-info__value">
			<?php echo wp_kses_post( $address ); ?>
		</span>
	</div>

</div>