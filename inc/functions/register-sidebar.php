<?php

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
if( ! function_exists('dcs_networking_widgets_init') ):
  
  function florida_expert_widgets_init() {
    
    $args = array(
      'name'          => esc_html__( 'Sidebar', 'florida-expert' ),
      'id'            => 'sidebar-1',
      'description'   => esc_html__( 'Add widgets here.', 'florida-expert' ),
      'before_widget' => '<section id="%1$s" class="widget %2$s">',
      'after_widget'  => '</section>',
      'before_title'  => '<h2 class="widget-title">',
      'after_title'   => '</h2>',
    );
    register_sidebar($args);    

  }

endif;
add_action( 'widgets_init', 'florida_expert_widgets_init' );