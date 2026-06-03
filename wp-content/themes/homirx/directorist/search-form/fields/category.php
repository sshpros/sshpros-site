<?php
/**
 * @author  wpWax
 * @since   6.6
 * @version 7.3.1
 */

if ( ! defined( 'ABSPATH' ) ) exit;
	$selected_item = $searchform::get_selected_category_option_data();
	if( empty($data['label']) ){ 
		$data['label'] = esc_html__('Category', 'homirx');
	}
?>
<div class="directorist-search-field">
	<div class="field-wrap">
		<div class="field-title"><?php echo esc_html($data['label']) ?></div>
		<div class="field-content">
			<div class="directorist-select directorist-search-category">
				<select name="in_cat" class="<?php echo esc_attr($searchform->category_class); ?>" data-placeholder="<?php echo esc_attr($data['placeholder']); ?>" <?php echo ! empty( $data['required'] ) ? 'required="required"' : ''; ?> data-isSearch="true" data-selected-id="<?php echo esc_attr( $selected_item['id'] ); ?>" data-selected-label="<?php echo esc_attr( $selected_item['label'] ); ?>">
					<?php
						echo '<option value="">' . esc_html($data['placeholder']) . '</option>';
						if ( empty( $data['lazy_load'] ) ) {
							echo directorist_kses( $searchform->categories_fields, 'form_input' );
						}
					?>
				</select>
			</div>
		</div>
	</div>
</div>