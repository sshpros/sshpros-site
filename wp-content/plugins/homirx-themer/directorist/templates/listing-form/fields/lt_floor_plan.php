<?php
/**
 * @author  wpWax
 * @since   6.6
 * @version 6.7
 */


use \Directorist\Helper;

if ( ! defined( 'ABSPATH' ) ) exit;
?>

<div class="directorist-form-group directorist-form-social-info-field">

	<?php $listing_form->field_label_template( $data );?>

	<div id="social_info_sortable_container">

		<input type="hidden" id="is_social_checked">

		<?php
		if ( !empty( $data['value'] ) ){
			foreach ( $data['value'] as $index => $floor_plan ) {
				if ( !$floor_plan ) {
					$index = 'socialindex';
					$floor_plan = [
						'id'   => '',
						'url'  => '',
					];
				}

				$args = array(
					'listing_form'   => $this,
					'index'          => $index,
					'social_info'    => $floor_plan,
				);

				
				$id = (array_key_exists('id', $args)) ? $args['id'] : $index; 
				?>

				<div class="directorist-form-social-fields" id="socialID-<?php echo esc_attr( $id ); ?>">
				    <div class="directorist-form-group">
				        <select name="social[<?php echo esc_attr( $id ); ?>][id]" class="directorist-form-element">
				            <?php foreach ( ATBDP()->helper->social_links() as $nameID => $socialName ) { ?>
				                <option value="<?php echo esc_attr($nameID); ?>" <?php selected($nameID, $social_info['id']); ?>><?php echo esc_html($socialName); ?></option>
				            <?php } ?>
				        </select>
				    </div>
				    <div class="directorist-form-group">
				        <input type="url" name="social[<?php echo esc_attr( $id ); ?>][url]" class="directorist-form-element directory_field atbdp_social_input" value="<?php echo esc_url($social_info['url']); ?>" placeholder="<?php esc_attr_e('eg. http://example.com', 'homirx-themer'); ?>" required>
				    </div>
				    <div class="directorist-form-group directorist-form-social-fields__action">
				        <span data-id="<?php echo esc_attr( $id ); ?>" class="directorist-form-social-fields__remove dashicons dashicons-trash" title="<?php esc_html_e('Remove this item', 'homirx-themer'); ?>"></span>
				    </div>
				</div>
			<?php

			}
		}
		?>

	</div>

	<button type="button" class="directorist-btn directorist-btn-primary directorist-btn-sm" id="addNewSocial"> <span class="plus-sign">+</span><?php esc_html_e('Add New', 'homirx-themer'); ?></button>

</div>