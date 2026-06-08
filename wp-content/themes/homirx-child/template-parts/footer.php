<?php $copyright = homirx_get_option( 'copyright_text', '' ); ?>

    </div><!-- end page-content -->
</div><!-- end wrapper-page -->

<footer id="wp-footer" class="clearfix">
    <div class="footer-widgets">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h4><?php echo esc_html( get_bloginfo( 'name' ) ); ?></h4>
                    <p><?php echo esc_html( get_bloginfo( 'description' ) ); ?></p>
                </div>
                <div class="col-md-4">
                    <?php
                    wp_nav_menu( array(
                        'theme_location' => 'footer',
                        'container'      => false,
                        'menu_class'     => 'footer-menu',
                        'depth'          => 1,
                        'fallback_cb'    => false,
                    ) );
                    ?>
                </div>
                <div class="col-md-4">
                    <?php get_template_part( 'templates/parts/socials' ); ?>
                </div>
            </div>
        </div>
    </div>
    <div class="copyright">
        <div class="container">
            <div class="copyright-content">
                <?php
                if ( ! empty( $copyright ) ) {
                    echo esc_html( $copyright );
                } else {
                    echo esc_html( 'Copyright ' . date( 'Y' ) . ' Security & Smarthome Pros. All rights reserved.' );
                }
                ?>
            </div>
        </div>
    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
