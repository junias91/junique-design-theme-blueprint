<?php 

/** Head Font Preloading **/
function font_preloading_preload_key_requests() { 
  
  $font_path        = THEME_ASSETS . '/fonts/junique-design';
  $font_path_icons  = THEME_ASSETS . '/fonts/junique-icons';

?>
<link rel="preload" as="font" type="font/woff2" crossorigin="anonymous" href="<?php echo $font_path; ?>/jq-400.woff2">
<link rel="preload" as="font" type="font/woff2" crossorigin="anonymous" href="<?php echo $font_path; ?>/jq-700.woff2">
<?php 
}
add_action( 'wp_head', 'font_preloading_preload_key_requests' );