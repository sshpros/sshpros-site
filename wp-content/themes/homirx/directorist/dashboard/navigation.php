<?php
/**
 * @author  wpWax
 * @since   6.6
 * @version 7.4.0
 */
use \Directorist\Directorist_Listing_Author;
if ( ! defined( 'ABSPATH' ) ) exit;

$counter = 1;
$author = Directorist_Listing_Author::instance();
?>

<div class="directorist-user-dashboard__nav directorist-tab__nav">
	<span class="directorist-dashboard__nav__close"><?php directorist_icon( 'las la-times' ); ?></span>
	<div class="directorist-tab__nav__wrapper">

		<div class="directorist-dashboard__author">

			<div class="directorist-dashboard__author__wrap">
				<div class="directorist-dashboard__author__avatar">
					<?php echo wp_kses_post( $author->avatar_html() ); ?>
				</div>
				<div class="directorist-dashboard__author__info">
					<h2 class="directorist-author-name directorist-author-profile__avatar__info__name"><?php echo esc_html( $author->display_name() ); ?></h2>
					<p><?php echo esc_html( $author->member_since_text() ); ?></p>
				</div>

				<ul class="directorist-dashboard__author__meta">
					<?php if ( $author->review_enabled() ): ?>
						<li class="directorist-author-meta-list__item">
							<?php directorist_icon( 'fas fa-star' ); ?>
							<span class="directorist-review-count">
								<?php echo wp_kses_post( $author->rating_count() ); ?>
								<?php echo wp_kses_post( $author->review_count_html() ); ?>
							</span>
						</li>
					<?php endif; ?>
					<li class="directorist-author-meta-list__item">
						<?php directorist_icon( 'fas fa-list-ol' ); ?>
						<span class="directorist-listing-count">
							<?php echo wp_kses_post( $author->listing_count_html() ); ?>
						</span>
					</li>
				</ul>
			</div>

		</div>

		<ul class="directorist-tab__nav__items">

			<?php foreach ( $dashboard->dashboard_tabs() as $key => $value ): ?>

				<li class="directorist-tab__nav__item">
					<a href="#" class="directorist-booking-nav-link directorist-tab__nav__link <?php echo esc_attr(( $counter == 1 ) ? 'directorist-tab__nav__active' : ''); ?>" target="<?php echo esc_attr( $key ); ?>">
						<span class="directorist_menuItem-text">
							<span class="directorist_menuItem-icon">
								<?php directorist_icon( $value['icon'] ); ?>
							</span>
							<?php echo wp_kses_post( $value['title'] ); ?>
						</span>
					</a>
				</li>

				<?php do_action( 'directorist_dashboard_navigation', $key, $dashboard ); ?>
				<?php $counter++; ?>

			<?php endforeach; ?>

			<?php do_action( 'directorist_after_dashboard_navigation', $dashboard ); ?>

		</ul>

	</div>

	<?php $dashboard->nav_buttons_template(); ?>

</div>