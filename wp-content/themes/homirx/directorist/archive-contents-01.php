<?php
/**
 * @author  wpWax
 * @since   6.6
 * @version 8.0
 */

if ( ! defined( 'ABSPATH' ) ) exit;

?>

<div <?php $listings->wrapper_class(); $listings->data_atts(); ?>>
	<div class="listing-with-sidebar archive-search-top">
		<div class="directorist-container">
			<div class="listing-search-top__wrapper">
				<div class="listing-search-top__type-nav">
					<?php
						$listings->directory_type_nav_template();
					?>
				</div>
				
				<div class="listing-search-top__searchform">
					<?php
						$search_field_atts = array_filter( $listings->atts, function( $key ) {
							return substr( $key, 0, 7 ) == 'filter_';
						}, ARRAY_FILTER_USE_KEY );

					 
						$searchform = new Directorist\Directorist_Listing_Search_Form( $listings->type, $listings->current_listing_type, $search_field_atts );

						if (is_numeric($searchform->listing_type)) {
							$term = get_term_by('id', $searchform->listing_type, ATBDP_TYPE);
							$listing_type = $term->slug;
						}
					?>
					<div class="directorist-archive-adv-filter directorist-advanced-filter">
						<form action="<?php atbdp_search_result_page_link(); ?>" class="directorist-advanced-filter__form">

							
								<input type="hidden" name='directory_type' value='<?php echo !empty($listing_type) ? esc_attr( $listing_type ) : esc_attr( $searchform->listing_type ); ?>'>
								
								<div class="searchform__basic">
									<?php foreach ($searchform->form_data[0]['fields'] as $field) : ?>
										<div class="directorist-advanced-filter__basic__element"><?php $searchform->field_template($field); ?></div>
									<?php endforeach; ?>
									
									<a class="searchform__advanced-button" href="#filter">
										<i class="fa-solid fa-filter"></i> <?php echo esc_html__('More', 'homirx'); ?>
									</a>	
								</div>

								<div class="searchform_advanced">
									<?php foreach ($searchform->form_data[1]['fields'] as $field) : ?>
										<div class="directorist-advanced-filter__advanced__element directorist-search-field-<?php echo esc_attr($field['widget_name']) ?>"><?php $searchform->field_template($field); ?></div>
									<?php endforeach; ?>
								</div>
							
								<?php $searchform->buttons_template(); ?>
						</form>
					</div>
				</div>

				<?php if( $listings->header ) : ?>
					<div class="listing-search-top__header">
						<?php
							$listings->header_bar_template();
						?>
					</div>
				<?php endif; ?>

				<div class="listing-search-top__contents">
					<section class="listing-search-top__listing">
						<?php
							$listings->archive_view_template();
						?>
					</section>
				</div>
			</div>
		</div>
	</div>

</div>