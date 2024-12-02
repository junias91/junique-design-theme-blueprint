<?php 

/**
 * add Logo
 * USE:
 * $logo_args = array(
 * 	'link'			=> true,
 *  'color'			=> 'primary'
 * 	'aligment'	=> ''	
 * );
 * logo($logo_args);
 */
if( ! function_exists('logo') ){
  function logo( array $data = NULL ){
    get_template_part( 'parts/logo', null, $data );
  }
}