<?php
/*
 * Template Name: Content Page
 */
get_header();
?>

<main id="wp-main-content" class="clearfix main-page">

    <?php get_template_part( 'template-parts/hero' ); ?>

    <section class="content-page">
        <div class="container">
            <div class="row">
                <div class="col-lg-10 offset-lg-1">
                    <?php if ( have_posts() ) : the_post(); ?>
                        <div class="content-body">
                            <?php the_content(); ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>

</main>

<?php get_footer(); ?>
