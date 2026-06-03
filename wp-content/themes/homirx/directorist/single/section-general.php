<?php
/**
 * @author  wpWax
 * @since   6.7
 * @version 6.7
 */

if ( ! defined( 'ABSPATH' ) ) exit;
?>

<div class="property-card property-card-general-section <?php echo esc_attr( $class );?>" <?php $listing->section_id( $id ); ?>>

	<div class="property-card__header">

		<h4 class="property-card__header--title"><?php directorist_icon( $icon );?><?php echo esc_html( $label );?></h4>

	</div>

	<div class="property-card__body">

		<div class="property-details-info-wrap">
			<?php
			foreach ( $section_data['fields'] as $field ) {
				$listing->field_template( $field );
			}
			?>
		</div>

	</div>

</div>