<?php

// Force error logging directly into wp-content/themes/chalicetheme/debug.txt
@error_reporting(E_ALL);
@ini_set('display_errors', '0');
@ini_set('log_errors', '1');
@ini_set('error_log', get_template_directory() . '/debug.txt');

/**
 * Chalice client assets and setup
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
        '1.0.0'
    );
}
add_action('wp_enqueue_scripts', 'chalice_frontend_assets');

// Remove the wp admin bar from top of theme
add_filter('show_admin_bar', '__return_false');

/**
 * Automatically deactivate the bridge plugin when switching away from Chalice Theme.
 */
add_action( 'switch_theme', function () {
    if ( ! function_exists( 'is_plugin_active' ) ) {
        require_once ABSPATH . 'wp-admin/includes/plugin.php';
    }

    $bridge = 'chalice-core/chalice-core.php';
    if ( is_plugin_active( $bridge ) ) {
        deactivate_plugins( $bridge, true ); // Silent deactivation; avoids redirect loops
    }
} );

/**
 * Prompt the user to activate the bridge plugin if Chalice Theme is active without it.
 */
add_action( 'admin_notices', function () {
    if ( defined( 'CHALICE_CORE_VERSION' ) || ! current_user_can( 'activate_plugins' ) ) {
        return;
    }

    $bridge = 'chalice-core/chalice-core.php';
    $url    = wp_nonce_url(
        admin_url( 'plugins.php?action=activate&plugin=' . urlencode( $bridge ) ),
        'activate-plugin_' . $bridge
    );

    printf(
        '<div class="notice notice-warning"><p><strong>Chalice Theme:</strong> Activate <strong>Chalice Theme Core</strong> to enable theme features and verify required plugins. <a href="%s" class="button button-small">Activate Chalice Theme Core</a></p></div>',
        esc_url( $url )
    );
} );

/**
 * Surface dependency status inside the Appearance > Themes preview modal.
 */
add_action( 'admin_footer-themes.php', function () {
    if ( ! function_exists( 'get_plugin_data' ) ) {
        require_once ABSPATH . 'wp-admin/includes/plugin.php';
    }

    $bridge_path = WP_PLUGIN_DIR . '/chalice-core/chalice-core.php';
    if ( ! file_exists( $bridge_path ) ) {
        return;
    }

    // Read the `Requires Plugins` header directly from the bridge plugin
    $headers  = get_file_data( $bridge_path, [ 'requires' => 'Requires Plugins' ] );
    $slugs    = array_filter( array_map( 'trim', explode( ',', $headers['requires'] ) ) );
    $active   = get_option( 'active_plugins', [] );
    $statuses = [];

    foreach ( $slugs as $slug ) {
        $is_active  = (bool) preg_grep( '#^' . preg_quote( $slug, '#' ) . '/#', $active );
        $statuses[] = esc_html( $slug ) . ' (' . ( $is_active ? '✅ Active' : '❌ Required' ) . ')';
    }

    if ( empty( $statuses ) ) {
        return;
    }
    ?>
    <script>
    document.addEventListener('DOMContentLoaded', () => {
        const themeSlug = <?php echo wp_json_encode( get_stylesheet() ); ?>;
        const summary   = <?php echo wp_json_encode( implode( ', ', $statuses ) ); ?>;

        new MutationObserver(() => {
            const modal = document.querySelector('.theme-overlay .theme-info');
            if (!modal || modal.dataset.depsInjected) return;

            const params   = new URLSearchParams(window.location.search);
            const isTarget = params.get('theme') === themeSlug ||
                             document.querySelector(`.theme[data-slug="${themeSlug}"].active`);

            if (isTarget) {
                modal.dataset.depsInjected = 'true';
                const notice = document.createElement('div');
                notice.className = 'notice notice-warning inline';
                notice.style.margin = '12px 0';
                notice.innerHTML = `<strong>Required Plugins:</strong> ${summary}`;
                modal.prepend(notice);
            }
        }).observe(document.body, { childList: true, subtree: true });
    });
    </script>
    <?php
} );