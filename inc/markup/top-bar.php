<?php 

function add_header(){
  $args = array();
  get_template_part( 'parts/site-header', null, $args);
}
add_action( 'the_header', 'add_header' );

function add_kontakt_menu(){
  kontakt_menu();
}
add_action('site_header_asside','add_kontakt_menu');