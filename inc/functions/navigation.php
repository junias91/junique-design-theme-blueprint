<?php 

/*	-----------------------------------------------------------------------------------------------
	MENUS
	Register navigational menus (wp_nav_menu)
--------------------------------------------------------------------------------------------------- */

if ( ! function_exists( 'menus' ) ) :
	function menus() {
    $locations = array(
      'main-menu'   			=> __( 'Main', 'junique' ),
      'footer-menu' 			=> __( 'Footer', 'junique' ),  
      'rechtliches-menu' 	=> __( 'Rechtliches', 'junique' ),  
      'kontakt-menu' 			=> __( 'Kontakt', 'junique' ),  
      'social-menu'				=> __( 'Social Media', 'junique' ),  
    );		
    register_nav_menus( $locations );

  }
endif;
add_action( 'init', 'menus' );



/**
 * Header menu
 */
if ( ! function_exists( 'main_menu' ) ) :
function main_menu() {
	if ( has_nav_menu( 'main-menu' ) ) {
		wp_nav_menu( array(
			'theme_location'  => 'main-menu',
			'container'       => 'nav',
			'container_class' => 'navigation main-menu',
			'container_id'    => null,
			'menu_id'      		=> null,
			'menu_class'      => 'js-navList',
			'fallback_cb'     => 'wp_bootstrap_navwalker::fallback',
			'walker'          => new wp_bootstrap_navwalker()
		));
	}
}
endif;

/**
 * Header menu
 */
if ( ! function_exists( 'kontakt_menu' ) ) :
function kontakt_menu() {
	if ( has_nav_menu( 'kontakt-menu' ) ) {
		wp_nav_menu( array(
			'theme_location'  => 'kontakt-menu',
			'container'       => 'nav',
			'container_class' => 'navigation main-menu',
			'container_id'    => null,
			'menu_id'      		=> null,
			'menu_class'      => 'js-navList',
			'fallback_cb'     => 'wp_bootstrap_navwalker::fallback',
			'walker'          => new wp_bootstrap_navwalker()
		));
	}
}
endif;


	
/**
* menu
*/
if ( ! function_exists( 'menu' ) ) :
	function menu( string $title = '' ) {
	
		if ( empty( $title ) ) return;
	
		$menu_object = wp_get_nav_menu_object( $title );
	
		if ( ! $menu_object ) return;
	
		$defaults = array(
			'menu'            => $menu_object->term_id,
			'container'       => null,
			'container_class' => null,
			'container_id'    => null,
			'menu_id'         => null,
			'menu_class'      =>'navigation ' . $menu_object->slug,
			'fallback_cb'     => null,
			'walker'          => new wp_bootstrap_navwalker()
		);
	
		wp_nav_menu( $defaults );
	}
endif;


/**
* Footer menu
*/
if ( ! function_exists( 'footer_menu' ) ) :
	function footer_menu() {

		if ( ! has_nav_menu( 'footer-menu' ) ) return;
		
		$defaults = array(
			'menu_id'         => null,
			'theme_location'  => 'footer-menu',
			'depth'           => 0,
			'container'       => null,
			'container_class' => null,
			'container_id'    => null,
			'menu_class'      => 'footer-navbar',
			'fallback_cb'     => 'wp_bootstrap_navwalker::fallback',
			'walker'          => new wp_bootstrap_navwalker()
		);
		wp_nav_menu( $defaults );

	}
endif;


/**
* Footer menu
*/
/**
* Social Media menu
*/
if ( ! function_exists( 'social_media_menu' ) ) :
	function social_media_menu() {
	if ( has_nav_menu( 'social-menu' ) ) {
		wp_nav_menu( array(
			'menu_id'         => '',      
			'theme_location'  => 'social-menu',
			'depth'           => 0,
			'container'       => '',
			'container_class' => '',
			'container_id'    => '',
			'menu_class'      => 'social-menu',
			'link_before'     => '<span class="screen-reader-text">',
			'link_after'     => '</span>',
		 ));
	}
	}
	endif;


// Header Fallback Menu
function nav_fallback() {
	wp_page_menu( array(
		'show_home'		=> true,
		'menu_class'	=> '',		// Adding custom nav class
		'include'		=> '',
		'exclude'		=> '',
		'echo'			=> true,
		'link_before'	=> '',		// Before each link
		'link_after'	=> ''		// After each link
	));
}



/*
 * Fügt dem Footer den Cookie Button hinzu
 */
function cookie_menu_link( $items, $args ) {
  if ($args->theme_location == 'footer-menu') {  	
		$_title = __('Cookie Einstellungen', 'junique-design');		
		$items .= '<li><button type="button" data-cc="show-preferencesModal">'.$_title.'</button></li>';
  }
  return $items;
}
add_filter( 'wp_nav_menu_items', 'cookie_menu_link', 10, 2 );



// add_filter('nav_menu_link_attributes', 'add_aria_controls_to_menu_link', 10, 3);
function add_aria_controls_to_menu_link($atts, $item, $args) { 
    // Erhalte ACF-Felder
    $has_dropdown = get_field('has_dropdown', $item);
    $id_dropdown 	= get_field('id_dropdown', $item);    
    // Falls Dropdown vorhanden, aria-controls hinzufügen
    if ($has_dropdown && $id_dropdown) {
        $atts['aria-controls'] = esc_attr($id_dropdown);
    }
    return $atts;
}// Filter für die Listenelement-Klasse


add_filter('wp_nav_menu_objects', 'add_class_to_menu_items', 10, 2);
function add_class_to_menu_items($items, $args) {
	
	global $post;

	$current_page_id = $post->ID;
	$ancestor_ids = get_post_ancestors($current_page_id);

	foreach ($items as &$item) {
			// Erhalte ACF-Felder
			$has_dropdown = get_field('has-a-dropdown', $item);

			// Falls Dropdown vorhanden, Klasse hinzufügen
			if ($has_dropdown) {
					$item->classes[] = 'menu-item-has-dropdown';
					$item->classes[] = 'menu-item-has-children';
				}			

			// Falls das Menüelement ein Vorfahre der aktuellen Seite ist, Klasse hinzufügen
			if (in_array($item->object_id, $ancestor_ids)) {
				$item->classes[] = 'current-page-ancestor';
			}
	}
    return $items;
}


function custom_menu_item_icon($title, $item, $args, $depth) {
	// Check if ACF field 'icon' exists and is not empty
	$icon = get_field('icon', $item);
	if (!empty($icon)) {
			// Add the icon before the menu item title
			$title = '<i class="junique-icon ' . esc_attr($icon) . '"></i>' . $title;
	}
	return $title;
}
add_filter('nav_menu_item_title', 'custom_menu_item_icon', 10, 4);



/**
 * Determine if Custom Post Type
 * usage: if ( is_this_a_custom_post_type() )
 *
 * References/Modified from:
 * @link https://codex.wordpress.org/Function_Reference/get_post_types
 * @link http://wordpress.stackexchange.com/users/73/toscho <== love this person!
 * @link http://wordpress.stackexchange.com/a/95906/64742
 */
function is_this_a_custom_post_type( $post = NULL ) {

	$all_custom_post_types = get_post_types( array ( '_builtin' => false ) );

	//* there are no custom post types
	if ( empty ( $all_custom_post_types ) ) return false;

	$custom_types      = array_keys( $all_custom_post_types );
	$current_post_type = get_post_type( $post );

	//* could not detect current type
	if ( ! $current_post_type ) return false;

	return in_array( $current_post_type, $custom_types );
}


// Add Foundation active class to menu
function required_active_nav_class( $classes, $item ) {
	if ( $item->current == 1 || $item->current_item_ancestor == true ) {
		$classes[] = 'active';
	}
	return $classes;
}
add_filter( 'nav_menu_css_class', 'required_active_nav_class', 10, 2 );



function my_css_attributes_filter($var) {
  return is_array($var) ? array_intersect($var, array('active')) : '';
}
// add_filter('nav_menu_css_class', 'my_css_attributes_filter', 100, 1);
// add_filter('nav_menu_item_id', 'my_css_attributes_filter', 100, 1);
// add_filter('page_css_class', 'my_css_attributes_filter', 100, 1);

/**
* Remove blog menu link class 'current_page_parent' when on an unrelated CPT
* or search results page
* dep: is_this_a_custom_post_type() function
* modified from: https://gist.github.com/ajithrn/1f059b2201d66f647b69
*/
function if_search_or_cpt_remove_current_page_parent_on_blog_page_link( $classes, $item, $args ) {
	if( is_this_a_custom_post_type() || is_search() || is_tax() ) :
		$blog_page_id = intval( get_option('page_for_posts') );
		if( $blog_page_id != 0 && $item->object_id == $blog_page_id ) :
			unset( $classes[array_search( 'current_page_parent', $classes )] );
		endif;
	endif;
	return $classes;
}
add_filter( 'nav_menu_css_class', 'if_search_or_cpt_remove_current_page_parent_on_blog_page_link', 10, 3 );


// Alle .current-menu-item werden global zu .active
function special_nav_class ($classes, $item) {
	if ( in_array('current-post-ancestor', $classes) || in_array('current-page-ancestor', $classes) || in_array('current-menu-item', $classes ) ){
		$classes[] = 'active ';
	}
	return $classes;
}
add_filter('nav_menu_css_class' , 'special_nav_class' , 10, 2);


// Custom Menü Punkte bekommen classe .active
function set_active_class_for_cpt( $menu ){
	global $post;

	if( !is_search() ){

		if ( is_category() || is_tax() || is_single() || is_singular() ){
			$menu = str_replace( 'current_page_parent', 'active', $menu ); // remove all current_page_parent classes
		}

		// Zwei spezifische Pages matchen
		// Karriere und Alle Stellenanzeigen
		if ( is_page(array(370,66)) ){
			$menu = str_replace( 'menu-item-102', 'menu-item-102 active', $menu ); // add the current_page_parent class to the page you want
		}

		// Single Leitung > highlight > Site Leitung
		if ( get_post_type($post) == 'leistungen'){
			$menu = str_replace( 'menu-item-104', 'menu-item-104 active', $menu ); // add the current_page_parent class to the page you want
		}

		// Seite Job > highlight > Über Uns
		if ( get_post_type($post) == 'produkt'){
			$menu = str_replace( 'menu-item-105', 'menu-item-64 active', $menu ); // add the current_page_parent class to the page you want
		}

		// Seite Job > highlight > Über Uns
		if (get_post_type($post) == 'jobs'){
			$menu = str_replace( 'menu-item-102', 'menu-item-102 active', $menu ); // add the current_page_parent class to the page you want
		}

	}
	return $menu;
}
add_filter( 'nav_menu_css_class', 'set_active_class_for_cpt', 10,2 );
