<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package blueprint
 */

?>
<!doctype html>
<html <?php language_attributes(); ?> dir="ltr" <?php html_class(array("no-js")); ?>> 
<head>
<?php header_top(); ?>
<meta charset="<?php bloginfo( 'charset' ); ?>">	
<meta http-equiv="X-UA-Compatible" content="IE=edge">	
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">	
<link rel="profile" href="https://gmpg.org/xfn/11">
<?php header_middel(); ?>
<?php wp_head(); ?>
<?php header_bottom(); ?>
</head>
<body <?php body_class(); ?> <?php junique_schema_body(); ?> itemscope itemtype="https://schema.org/WebPage">
<?php wp_body_open(); ?>



<a class="skip-link screen-reader-text" href="#site-main"><?php esc_html_e( 'Skip to content', 'blueprint' ); ?></a>
<?php the_header(); ?>