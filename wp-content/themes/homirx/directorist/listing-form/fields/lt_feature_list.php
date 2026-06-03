<?php
/**
 * @author  wpWax
 * @since   6.6
 * @version 6.7
 */


use \Directorist\Helper;

if ( ! defined( 'ABSPATH' ) ) exit;
?>

<div class="directorist-form-group directorist-form-feature-list-field">

	<?php $listing_form->field_label_template( $data );?>
	
	<textarea name="<?php echo esc_attr( $data['field_key'] ); ?>" id="<?php echo esc_attr( $data['field_key'] ); ?>" class="directorist-form-element" rows="8" placeholder="<?php echo esc_attr( $data['placeholder'] ); ?>" maxlength="<?php echo esc_attr( $maxlength ); ?>" <?php $listing_form->required( $data ); ?>><?php echo esc_html( $data['value'] ); ?></textarea>

	<?php $listing_form->field_description_template( $data );?>
</div>