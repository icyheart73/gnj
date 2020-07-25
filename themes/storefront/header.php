<!doctype html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=2.0">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<?php set_product_cookie(); ?>
<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<?php global $GanjeSetting; ?>

<div id="page" class="hfeed site">
	<header id="masthead" class="site-header" role="banner">

		<?php
		do_action( 'ganje_header' );
		?>

	</header><!-- #masthead -->

	<div id="content" class="site-content" tabindex="-1">
		<div class="col-full">
