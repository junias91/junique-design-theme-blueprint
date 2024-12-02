<?php


// Rank Math Breadcrumb.
add_theme_support( 'rank-math-breadcrumbs' );


// SEO Rank Math 
add_filter( 'rank_math/metabox/priority', function( $priority ) {
  return 'low';
});


/**
 * Filter to change breadcrumb settings.
 *
 * @param  array $settings Breadcrumb Settings.
 * @return array $setting.
 */
add_filter( 'rank_math/frontend/breadcrumb/settings', function( $settings ) {
  $settings = array(
    'home'           => true,
    'separator'      => '',
    'remove_title'   => '',
    'hide_tax_name'  => '',
    'show_ancestors' => '',
  );
  return $settings;
});