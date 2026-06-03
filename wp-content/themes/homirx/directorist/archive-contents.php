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
					<div class=searchform__basic>
						<?php
							$listings->basic_search_form_template();
							echo '<a class="searchform__advanced-button" href="#filter">';
								echo '<i class="fa-solid fa-filter"></i>';
								echo esc_html__('More', 'homirx');
							echo '</a>';
						?>
					</div>
					<div class="searchform_advanced">
						<?php
							$listings->advance_search_form_template();
						?>
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