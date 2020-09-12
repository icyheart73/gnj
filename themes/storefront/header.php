<!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=2.0">
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
    <?php set_product_cookie(); ?>
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="hfeed site">
    <header id="masthead" class="site-header container-fluid" role="banner">
        <div class="row">
            <?php
            global $GanjeSetting;
            require_once 'template-part/headers/' . $GanjeSetting['header_style'] . '.php';
            ?>
        </div>
    </header><!-- #masthead -->

    <div id="content" class="site-content" tabindex="-1">
        <div class="col-full">
