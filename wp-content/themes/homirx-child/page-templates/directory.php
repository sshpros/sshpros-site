<?php
/*
 * Template Name: Directory Page
 */
get_header();
?>

<main id="wp-main-content" class="clearfix main-page">

    <?php get_template_part( 'template-parts/hero' ); ?>

    <section class="directory-content">
        <div class="container">
            <?php if ( have_posts() ) : the_post(); ?>
                <div class="directory-body">
                    <?php the_content(); ?>
                </div>
            <?php endif; ?>
        </div>
    </section>

</main>

<?php get_footer(); ?>
