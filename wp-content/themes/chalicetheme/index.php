<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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