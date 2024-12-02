<?php

/**
 * blueprint functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package blueprint
 */
if(!defined('VERSION'))					define('VERSION', '1.0.0' );	// Replace the version number of the theme on each release.
if(!defined('LINK' ) )					define('LINK',get_stylesheet_directory_uri());
if(!defined('THEME_DIR'))				define('THEME_DIR',get_template_directory());
if(!defined('THEME_URI'))				define('THEME_URI',get_template_directory_uri());
if(!defined('THEME_ASSETS'))    define('THEME_ASSETS',THEME_URI.'/assets');
if(!defined('THEME_CSS_DIR'))   define('THEME_CSS_DIR',THEME_ASSETS.'/css');
if(!defined('THEME_JS_DIR'))    define('THEME_JS_DIR',THEME_ASSETS.'/js');
if(!defined('THEME_IMG_DIR'))   define('THEME_IMG_DIR',THEME_ASSETS.'/img');
if(!defined('THEME_INC'))		    define('THEME_INC',THEME_DIR.'/inc/');
if(!defined('THEME_PARTS'))    	define('THEME_PARTS',THEME_URI.'/parts');
if(!defined('THEME_FUNCTIONS')) define('THEME_FUNCTIONS',THEME_DIR.'/inc/functions/');
if(!defined('THEME_MARKUP'))    define('THEME_MARKUP',THEME_DIR.'/inc/markup/');
if(!defined('THEME_HELPER'))    define('THEME_HELPER',THEME_DIR.'/inc/helper/');
if(!defined('ACF_PRO_LICENSE'))	define('ACF_PRO_LICENSE', 'b3JkZXJfaWQ9MTIyNDIzfHR5cGU9ZGV2ZWxvcGVyfGRhdGU9MjAxOC0wMS0xMiAxMzo1ODo1OQ==' );


/**
 *  Theme support options
 */
require THEME_FUNCTIONS . 'theme-support.php'; 


/**
 * Helper Class
 */
require THEME_HELPER . 'helper.php'; 


/**
 * Add Theme functions
 */
require THEME_FUNCTIONS . 'theme-functions.php';


/**
 * Markup 
 */
require THEME_MARKUP . 'markup.php';


/**
 *  JUNIQUE Design
 *  Reset
 ** - WordPress Funktionen werden zurückgesetzt.
 ** - WordPress wird um Funktionen erweitert.
 */
require THEME_FUNCTIONS . 'junique-design.php';


/**
 * JUNIQUE Design 
 * Navigation 
 */
require THEME_MARKUP . 'navigtion.php';

/**
 * Register widget area.
 */
require THEME_FUNCTIONS . 'register-sidebar.php';


/**
 * Register scripts and stylesheets
 */
require THEME_FUNCTIONS . 'enqueue-scripts.php';


/**
 * Register Images
 */
require THEME_FUNCTIONS . 'images.php';



/**
 * SVGS Icons
 * Use: get_icon_svg('link', '24px');
 */
require THEME_INC . 'classes/class-svg-icons.php';
require THEME_FUNCTIONS . 'svg-icons.php';


/**
 * Navigation Walker
 * Register custom menus and menu walkers
 */
require THEME_INC . 'classes/class-walker-nav.php';
require THEME_FUNCTIONS . 'navigation.php';


/**
 * Navigation Breadcrumb
 * Register custom menus and menu walkers
 */
require THEME_INC . 'classes/class-breadcrumb.php';
require THEME_FUNCTIONS . 'breadcrumb.php';


/**
 * Avatar
 */
require THEME_FUNCTIONS . 'avatar.php';


/**
 * Favicon
 */
// require THEME_FUNCTIONS . 'favicon.php';


/**
 * Fonts
 */
// require THEME_FUNCTIONS . 'enqueue-fonts.php'; 


/**
 * ACF Options Page
 */
require THEME_FUNCTIONS . 'acf.php';


/**
 * Add Schema Daten
 */
require THEME_FUNCTIONS . 'schema-org.php';


/**
 * Theme & Plugin Updateer
 * 
 */
require THEME_INC . 'updater/boot.php';
require THEME_INC . 'updater/updater.php';
require THEME_INC . 'updater/plugin-updater.php';
require THEME_INC . 'updater/theme-updater.php'; 

$updater = MakeitWorkPress\WP_Updater\Boot::instance(); 
// $updater->add(['type' => 'plugin', 'source' => 'https://github.com/makeitworkpress/wp-updater']);
$updater->add(['type' => 'theme', 'source' => 'https://github.com/junias91/ibit']);