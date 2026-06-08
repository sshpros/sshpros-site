<?php
function homirx_child_enqueue_styles() {
    wp_enqueue_style(
        'homirx-parent-style',
        get_template_directory_uri() . '/style.css'
    );
    wp_enqueue_style(
        'homirx-child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array( 'homirx-parent-style' )
    );
}
add_action( 'wp_enqueue_scripts', 'homirx_child_enqueue_styles' );
