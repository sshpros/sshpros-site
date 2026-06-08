<?php
/*
 * Template Name: Service Page
 */
get_header();
?>

<main id="wp-main-content" class="clearfix main-page">

    <?php get_template_part( 'template-parts/hero' ); ?>

    <section class="service-content">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <?php if ( have_posts() ) : the_post(); ?>
                        <div class="service-body">
                            <?php the_content(); ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-lg-4">
                    <div class="service-sidebar">
                        <div class="sidebar-cta">
                            <h3><?php esc_html_e( 'Get a Free Quote', 'homirx-child' ); ?></h3>
                            <p><?php esc_html_e( 'Contact us to discuss your security needs.', 'homirx-child' ); ?></p>
                            <?php $contact = get_page_by_path( 'contact' ); ?>
                            <?php if ( $contact ) : ?>
                                <a href="<?php echo esc_url( get_permalink( $contact->ID ) ); ?>" class="btn btn-primary btn-block">
                                    <?php esc_html_e( 'Contact Us', 'homirx-child' ); ?>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="service-cta">
        <div class="container text-center">
            <h2><?php esc_html_e( 'Ready to get started?', 'homirx-child' ); ?></h2>
            <?php $contact2 = get_page_by_path( 'contact' ); ?>
            <?php if ( $contact2 ) : ?>
                <a href="<?php echo esc_url( get_permalink( $contact2->ID ) ); ?>" class="btn btn-primary">
                    <?php esc_html_e( 'Request a Consultation', 'homirx-child' ); ?>
                </a>
            <?php endif; ?>
        </div>
    </section>

</main>

<?php get_footer(); ?>
