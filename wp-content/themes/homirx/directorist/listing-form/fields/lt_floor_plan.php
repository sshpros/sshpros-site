<?php
/**
 * @author  wpWax
 * @since   6.6
 * @version 6.7
 */
use \Directorist\Helper;

if ( ! defined( 'ABSPATH' ) ) exit;
?>

<div class="directorist-form-group directorist-form-floor-plan-field">
	<?php $listing_form->field_label_template( $data );?>

	<div id="floor_plan_sortable_container">
		<input type="hidden" id="is_floor_plan_checked">
		<?php
		$_index = 0;
		if ( !empty( $data['value'] ) ){
			foreach ( $data['value'] as $index => $floor_plan ) {
				if ( !$floor_plan ) {
					$floor_plan = [
						'title'   => '',
						'desc'  => '',
					];
				}

				$args = array(
					'index'          => $index,
					'floor_plan'    => $floor_plan,
				);
				$id = (array_key_exists('id', $args)) ? $args['id'] : $index; 
				?>
				<div class="floor_plan-field-item floor-plan-item" id="floorPlanID-<?php echo esc_attr( $id ); ?>">
					<div class="field-content">  
					   <div class="directorist-form-group field-title">
					   	<label><?php echo esc_html__('Title', 'homirx') ?></label>
					      <input type="text" name="lt_floor_plan[<?php echo esc_attr( $id ); ?>][title]" class="directorist-form-element directory_field" value="<?php echo esc_attr($floor_plan['title']); ?>" placeholder="<?php esc_attr_e('Add Title', 'homirx'); ?>" required>
					   </div>
					   <div class="directorist-form-group field-image">
					   	<label><?php echo esc_html__('Image Url', 'homirx') ?></label>
					      <input type="text" name="lt_floor_plan[<?php echo esc_attr( $id ); ?>][image]" class="directorist-form-element directory_field" value="<?php echo esc_attr($floor_plan['image']); ?>" placeholder="<?php esc_attr_e('Add Image Url', 'homirx'); ?>">
					   </div>
					   <div class="directorist-form-group field-desc">
					   	<label><?php echo esc_html__('Description', 'homirx') ?></label>
					   	<textarea name="lt_floor_plan[<?php echo esc_attr( $id ); ?>][desc]" class="directorist-form-element directory_field" placeholder="<?php esc_attr_e('Add Your Description', 'homirx'); ?>"><?php echo esc_html($floor_plan['desc']); ?></textarea>
					   </div>
					</div>
				   <div class="floor-plan-fields__action">
				      <a href="#" data-item="floorPlanID-<?php echo esc_attr( $id ); ?>" class="floor-plan-fields__remove dashicons dashicons-trash" title="<?php esc_attr_e('Remove this item', 'homirx'); ?>"></a>
				   </div>
				</div>
			<?php
			$_index++;
			}
		}
		?>
	</div>
	<input type="hidden" id="floor_plan_index" value="<?php echo esc_attr($_index) ?>">
	<button type="button" class="directorist-btn directorist-btn-primary directorist-btn-sm" id="addFloorPlan"> <span class="plus-sign">+</span><?php esc_html_e('Add New', 'homirx'); ?></button>
</div>