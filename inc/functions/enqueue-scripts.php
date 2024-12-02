<?php



/**
 * Enqueue scripts.
 */
if ( ! function_exists( 'junique_register_styles' ) ){
  function junique_register_styles() {     
    wp_enqueue_style( 'junique-design-style', THEME_CSS_DIR . '/style.min.css', array(), VERSION );   
    wp_enqueue_style( 'cookieconsent', THEME_CSS_DIR . '/cookieconsent.min.css', array(), '3.0.0' );   
    // wp_enqueue_style( 'accessibility', THEME_CSS_DIR . '/accessibility.min.css', array(), VERSION );   
    // wp_enqueue_style('print-style', THEME_CSS_DIR . '/print.min.css', array(), VERSION, 'print');

    if (is_user_logged_in()) {
      wp_enqueue_style('custom-logged-in-css', THEME_CSS_DIR . '/wordpress.min.css', array(), VERSION, 'all');
    }

  }
  add_action( 'wp_enqueue_scripts', 'junique_register_styles', 999 );
}

/**
 * Enqueue scripts.
 */
if ( ! function_exists( 'junique_register_scripts' ) ) :
  
  function junique_register_scripts() {
    
    // WordPress Data use in JavaScript
    $wp_data_array = array(
      'home_url'    => home_url(),
      'theme_url'   => THEME_URI,
      'ajax_url'    => admin_url( 'admin-ajax.php' ),
      'site_url'    => get_bloginfo('url'),
      'site_title'  => get_bloginfo('name'),
      'current_url' => get_the_permalink( get_the_ID() ),
      'buttontxt'   => esc_html__('mehr laden <i class="icons arrow-down"></i>','junique-design'),
      'buttonload'  => __('Loading ...','junique-design'),
      'nonce'       => wp_create_nonce('blog_filter_nonce'),
      'language'    => get_locale(),  // Füge die aktuelle Sprache hinzu  
      'privacy_policy_url' => get_permalink(get_option('wp_page_for_privacy_policy')),
    ); 
 
    wp_enqueue_script('jquery'); 



    // JavaScript Plugins        
    wp_register_script( 'swiper', THEME_JS_DIR . '/swiper.js', array(), VERSION, true );        
    wp_register_script( 'junique-plugins', THEME_JS_DIR . '/plugins.min.js', array(), VERSION, true );	            
    wp_register_script( 'junique-main', THEME_JS_DIR . '/main.js', array('junique-plugins'), VERSION, true );		            
    wp_register_script( 'junique-cookieconsent', THEME_JS_DIR . '/cookie-concent.min.js', array(), '3.0.1', true );
    
    //
    wp_enqueue_script('swiper');
    wp_enqueue_script('junique-plugins');
    wp_enqueue_script('junique-main');
    wp_enqueue_script('junique-cookieconsent');


    // übergibt die variabbeln ans js
    wp_localize_script( 'junique-plugins', 'jq_strings', $wp_data_array);


  }
  add_action( 'wp_enqueue_scripts', 'junique_register_scripts', 999);

endif;


