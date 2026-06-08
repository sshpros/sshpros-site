<?php
/*
 * Template Name: Events Page
 */
get_header();
?>

<main id="wp-main-content" class="clearfix main-page">

    <?php get_template_part( 'template-parts/hero', null, array( 'title' => esc_html__( 'Events', 'homirx-child' ) ) ); ?>

    <section class="events-content">
        <div class="container">
            <?php if ( have_posts() ) : the_post(); ?>
                <div class="events-body">
                    <?php the_content(); ?>
                </div>
            <?php endif; ?>
        </div>
    </section>

</main>

<?php get_footer(); ?>
