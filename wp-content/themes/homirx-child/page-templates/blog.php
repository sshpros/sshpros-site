<?php
/*
 * Template Name: Blog Page
 */
get_header();
$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
$query = new WP_Query( array(
    'post_type'      => 'post',
    'posts_per_page' => 9,
    'paged'          => $paged,
) );
?>

<main id="wp-main-content" class="clearfix main-page">

    <?php get_template_part( 'template-parts/hero', null, array( 'title' => esc_html__( 'News & Updates', 'homirx-child' ) ) ); ?>

    <section class="blog-archive">
        <div class="container">
            <div class="row">
                <?php if ( $query->have_posts() ) : while ( $query->have_posts() ) : $query->the_post(); ?>
                <div class="col-md-4">
                    <article class="blog-card">
                        <?php if ( has_post_thumbnail() ) : ?>
                            <a href="<?php echo esc_url( get_permalink() ); ?>" class="blog-card-image">
                                <?php echo wp_kses_post( get_the_post_thumbnail( null, 'medium' ) ); ?>
                            </a>
                        <?php endif; ?>
                        <div class="blog-card-body">
                            <h3 class="blog-card-title">
                                <a href="<?php echo esc_url( get_permalink() ); ?>"><?php echo esc_html( get_the_title() ); ?></a>
                            </h3>
                            <p class="blog-card-meta"><?php echo esc_html( get_the_date() ); ?></p>
                            <p class="blog-card-excerpt"><?php the_excerpt(); ?></p>
                        </div>
                    </article>
                </div>
                <?php endwhile; wp_reset_postdata(); endif; ?>
            </div>
            <div class="blog-pagination text-center">
                <?php
                echo paginate_links( array(
                    'total'   => $query->max_num_pages,
                    'current' => $paged,
                ) );
                ?>
            </div>
        </div>
    </section>

</main>

<?php get_footer(); ?>
