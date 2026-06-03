<?php
/**
 * @author  wpWax
 * @since   6.6
 * @version 7.3.1
 */

if ( ! defined( 'ABSPATH' ) ) exit;

$ptype = $searchform->get_pricing_type();
$max_placeholder = !empty( $data['price_range_max_placeholder'] ) ? $data['price_range_max_placeholder'] : '';
$min_placeholder = !empty( $data['price_range_min_placeholder'] ) ? $data['price_range_min_placeholder'] : '';

if(empty($data['label'])){
	$data['label'] = esc_html__('Price', 'homirx');
}
$price_min = !empty($searchform->price_value('min')) ? $searchform->price_value('min') : '0';

?>

<div class="directorist-search-field">

	<?php if ( !empty($data['label']) ): ?>
		<label><?php echo esc_html( $data['label'] ); ?></label>
	<?php endif; ?>

	<div class="directorist-price-ranges">

		<?php if ( $ptype == 'both' || $ptype == 'price_unit' ): ?>

			<div class="directorist-price-ranges__item directorist-form-group">
				<span class="label"><?php echo esc_html( $min_placeholder ); ?></span>
				<input type="number" name="price[0]" class="directorist-form-element price-search-min" min="0" placeholder="0" value="<?php echo esc_attr( $price_min ); ?>">
			</div>
			<div class="directorist-price-ranges__item directorist-form-group">
				<span class="label"><?php echo esc_html( $max_placeholder ); ?></span>
				<input type="number" name="price[1]" class="directorist-form-element" min="0" placeholder="99999" value="<?php echo esc_attr( $searchform->price_value('max') ); ?>">
			</div>
			
		<?php endif; ?>

		<?php if ( $ptype == 'both' || $ptype == 'price_range' ): ?>

			<div class="directorist-price-ranges__item directorist-price-ranges__price-frequency">
				<label class="directorist-price-ranges__price-frequency--btn">
					<?php $searchform->the_price_range_input('bellow_economy');?><span class="directorist-pf-range"><?php echo esc_html( str_repeat($searchform->c_symbol, 1) ); ?></span>
				</label>
				<label class="directorist-price-ranges__price-frequency--btn">
					<?php $searchform->the_price_range_input('economy');?><span class="directorist-pf-range"><?php echo esc_html( str_repeat($searchform->c_symbol, 2) ); ?></span>
				</label>
				<label class="directorist-price-ranges__price-frequency--btn">
					<?php $searchform->the_price_range_input('moderate');?><span class="directorist-pf-range"><?php echo esc_html( str_repeat($searchform->c_symbol, 3) ); ?></span>
				</label>
				<label class="directorist-price-ranges__price-frequency--btn">
					<?php $searchform->the_price_range_input('skimming');?><span class="directorist-pf-range"><?php echo esc_html( str_repeat($searchform->c_symbol, 4) ); ?></span>
				</label>
			</div>

		<?php endif; ?>

	</div>

</div>

