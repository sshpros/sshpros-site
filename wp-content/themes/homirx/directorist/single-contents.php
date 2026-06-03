<?php
/**
 * @author  wpWax
 * @since   6.7
 * @version 7.3.1
 */

use \Directorist\Directorist_Single_Listing;
use \Directorist\Helper;

if ( ! defined( 'ABSPATH' ) ) exit;

$listing = Directorist_Single_Listing::instance();
$sidebar_widgets = get_term_meta( $listing->type, 'single_listings_sidebar', true );
$id = $listing->id;
$address = get_post_meta( $id, '_address', true );
?>

<div class="property-single-contents-area">
	<?php do_action('homirx_page_breacrumb'); ?>
	<div class="<?php Helper::directorist_container_fluid(); ?>">
		<?php $listing->notice_template(); ?>

		<div class="property-single">
			<?php Helper::get_template( 'single/top-actions' ); ?>

			<div class="property-single__wrap">
				

				<div class="property-single__container">
					<div class="property-single__main-content">
						
						
						<?php if ( $listing->single_page_enabled() ): ?>
							<div class="directorist-single-wrapper">
								<?php
									// Output already filtered
									// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
									echo wpautop($listing->single_page_content());
								?>
							</div>

						<?php else: ?>
							<div class="directorist-single-wrapper">
								<?php
									$listing->header_template();
									foreach ( $listing->content_data as $section ) {
										$listing->section_template( $section );
									}
								?>
							</div>
						<?php endif; ?>

					</div>

					<?php 
						if(is_active_sidebar('right-sidebar-listing') || $sidebar_widgets) { 
							echo '<div class="property-single__sidebar">';
								if(function_exists('homirx_themer_single_data')){
									$sidebar_data = homirx_themer_single_data($sidebar_widgets, $listing->type);
									foreach ( $sidebar_data as $section ) {
										$listing->section_template( $section );
									}
								}
							 	dynamic_sidebar( 'right-sidebar-listing' );
							echo '</div>';
						}
					?>
				</div>

			</div>
					
		</div>
	</div>
</div>