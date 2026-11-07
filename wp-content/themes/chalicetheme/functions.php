<?php
/**
 * Chalice client
 */

function chalice_frontend_assets() {
    wp_enqueue_script(
        'chalice-client',
        get_template_directory_uri() . '/dist/app.js',
        array(),
        '1.0.0',
        true
    );
}

add_action('wp_enqueue_scripts', function () {
    wp_enqueue_script_module(
        'chalice-client',
        get_template_directory_uri() . '/dist/app.js',
        array(),
        '1.0.0'
    );
});

add_filter('show_admin_bar', '__return_false');