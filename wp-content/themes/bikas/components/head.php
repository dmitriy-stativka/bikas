<?php $build_folder = get_template_directory_uri() . '/assets/build/' ?>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="Description" content="default">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="preload" href="<?php echo $build_folder ?>fonts/PT-Regular.woff2" as="font" crossorigin="anonymous">
    <link rel="preload" href="<?php echo $build_folder ?>fonts/PT-Bold.woff2" as="font" crossorigin="anonymous">
    <link rel="preload" href="<?php echo $build_folder ?>fonts/Proxima-Light.woff2" as="font" crossorigin="anonymous">
    <link rel="preload" href="<?php echo $build_folder ?>fonts/Proxima-Regular.woff2" as="font" crossorigin="anonymous">
    <link rel="preload" href="<?php echo $build_folder ?>fonts/Proxima-Regular-italic.woff2" as="font"
        crossorigin="anonymous">
    <link rel="preload" href="<?php echo $build_folder ?>fonts/Proxima-Semibold.woff2" as="font"
        crossorigin="anonymous">
    <link rel="preload" href="<?php echo $build_folder ?>fonts/Proxima-Bold.woff2" as="font" crossorigin="anonymous">
    <link rel="preload" href="<?php echo $build_folder ?>fonts/Proxima-Black.woff2" as="font" crossorigin="anonymous">
    <link rel="preload" href="<?php echo $build_folder ?>fonts/Futura-Regular.woff2" as="font" crossorigin="anonymous">
    <link rel="preload" href="<?php echo $build_folder ?>fonts/Futura-Bold.woff2" as="font" crossorigin="anonymous">
    <title></title>

    <?php wp_head(); ?>
</head>