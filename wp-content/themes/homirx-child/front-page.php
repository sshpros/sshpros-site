<?php get_header(); ?>

<main id="wp-main-content" class="clearfix main-page">

    <section class="home-hero">
        <div class="container">
            <div class="home-hero-inner">
                <h1 class="home-hero-title">
                    <?php echo esc_html( get_bloginfo( 'name' ) ); ?>
                </h1>
                <p class="home-hero-subtitle">
                    <?php echo esc_html( get_bloginfo( 'description' ) ); ?>
                </p>
                <?php
                $contact_page = get_page_by_path( 'contact' );
                if ( $contact_page ) : ?>
                    <a href="<?php echo esc_url( get_permalink( $contact_page->ID ) ); ?>" class="btn btn-primary">
                        <?php esc_html_e( 'Get a Free Quote', 'homirx-child' ); ?>
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <section class="home-services">
        <div class="container">
            <h2 class="section-title text-center"><?php esc_html_e( 'Our Services', 'homirx-child' ); ?></h2>
            <div class="row">
                <?php
                $service_slugs = array(
                    'cameras',
                    'monitored-alarms',
                    'smart-locks',
                    'home-automation',
                    'surveillance-cctv',
                    'network-and-it-management',
                    'home-theatre-audio-visual-solutions',
                    'smart-climate-control',
                    'access-control-and-ada-compliance',
                    'subcontracting-and-smarthands',
                    'pre-wire-for-custom-builds',
                );
                foreach ( $service_slugs as $slug ) :
                    $page = get_page_by_path( $slug );
                    if ( ! $page ) continue;
                ?>
                <div class="col-md-4 col-sm-6">
                    <div class="service-card">
                        <?php if ( has_post_thumbnail( $page->ID ) ) : ?>
                            <div class="service-card-image">
                                <?php echo get_the_post_thumbnail( $page->ID, 'medium' ); ?>
                            </div>
                        <?php endif; ?>
                        <h3 class="service-card-title">
                            <a href="<?php echo esc_url( get_permalink( $page->ID ) ); ?>">
                                <?php echo esc_html( get_the_title( $page->ID ) ); ?>
                            </a>
                        </h3>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <section class="home-cta">
        <div class="container text-center">
            <h2><?php esc_html_e( 'Ready to protect your home?', 'homirx-child' ); ?></h2>
            <p><?php esc_html_e( 'Contact us today for a free consultation.', 'homirx-child' ); ?></p>
            <?php if ( $contact_page ) : ?>
                <a href="<?php echo esc_url( get_permalink( $contact_page->ID ) ); ?>" class="btn btn-primary">
                    <?php esc_html_e( 'Contact Us', 'homirx-child' ); ?>
                </a>
            <?php endif; ?>
        </div>
    </section>

</main>

<?php get_footer(); ?>
