<?php

if( ! class_exists('ACF') ) return; 


// ACF als jeson local ablegen
if ( ! function_exists( 'acf_json_save_point' ) ) :
	function acf_json_save_point( $path ) {
		// --> Save the custom fields in the [ THEME ] folder
		$path = get_template_directory() . '/inc/acf-json';  
		return $path;
	}
endif;
add_filter('acf/settings/save_json', 'acf_json_save_point');


// options pages

function register_acf_options_pages() {

  // Check function exists.
  if( !function_exists('acf_add_options_page') ) return;

	acf_add_options_page(array(
		'page_title' 	=> 'Theme',
		'menu_title'	=> 'Theme',
		'menu_slug' 	=> 'theme-settings',
		'capability'	=> 'edit_posts',
		'icon_url'    => 'dashicons-tagcloud',
		'position'    => 1,
		'redirect'		  => true
	));
	
	acf_add_options_sub_page(array(
		'page_title' 	=> 'Firmendaten',
		'menu_title'	=> 'Firmendaten',
		'parent_slug'	=> 'theme-settings',
	));	
	
	acf_add_options_sub_page(array(
		'page_title' 	=> 'Footer',
		'menu_title'	=> 'Footer',
		'parent_slug'	=> 'theme-settings',
	));	
	
	acf_add_options_sub_page(array(
		'page_title' 	=> 'Related post',
		'menu_title'	=> 'Related post',
		'parent_slug'	=> 'theme-settings',
	));	
  
}
// Hook into acf initialization.
add_action('acf/init', 'register_acf_options_pages');