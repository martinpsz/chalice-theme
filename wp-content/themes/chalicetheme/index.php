<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="<?php echo esc_url(get_template_directory_uri() . '/dist/favicon.ico'); ?>">
    <title>Chalice</title>
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
    <main id="app">
        <chalice-app></chalice-app>
    </main>
    <?php wp_footer(); ?>
</body>
</html>