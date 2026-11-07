<?php
/**
 * Chalice client
 */

function chalice_frontend_assets() {
    wp_enqueue_style(
        'chalice-styles',
        get_template_directory_uri() . '/dist/style.css',
        array(),
        '1.0.0'
    );

    wp_enqueue_script_module(
        'chalice-client',
        get_template_directory_uri() . '/dist/app.js',
        array(),
        '1.0.0',
    );
}

add_action('wp_enqueue_scripts', 'chalice_frontend_assets');


//remove the wp admin bar from top of theme;
add_filter('show_admin_bar', '__return_false');