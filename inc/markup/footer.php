<?php 

if( ! function_exists('the_footer') ){
  function the_footer(){
    $data = array();
    get_template_part( 'parts/site-footer', '', $data);
  }
}


add_action( 'wp_body_close', 'the_footer', 999 );