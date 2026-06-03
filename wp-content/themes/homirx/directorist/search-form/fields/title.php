<?php
/**
 * @author  wpWax
 * @since   6.6
 * @version 7.3.1
 */

if ( ! defined( 'ABSPATH' ) ) exit;

$value = isset( $_GET['q'] ) ? sanitize_text_field( wp_unslash( $_GET['q'] ) ) : '';
?>
<div class="directorist-search-field directorist-form-group">
	<div class="field-wrap">
		<div class="field-title"><?php echo esc_html__('Keyword', 'homirx') ?></div>
		<div class="field-content">
			<div class="directorist-form-group directorist-search-query">
				<input class="input-search-keywork" type="text" name="q" value="<?php echo esc_attr( $value ); ?>" placeholder="<?php echo esc_attr( $data['placeholder'] ); ?>" <?php echo ! empty( $data['required'] ) ? 'required="required"' : ''; ?>>
			</div>
		</div>
	</div>
</div>