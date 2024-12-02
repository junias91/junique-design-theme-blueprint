<?php 

/*
 * Custom filter to remove default image sizes from WordPress.
 */
 
/* Add the following code in the theme's functions.php and disable any unset function as required */
function remove_default_image_sizes( $sizes ) {
  
  /* Default WordPress */
  unset( $sizes[ '1536x1536' ]);       // Remove Thumbnail (150 x 150 hard cropped)
  unset( $sizes[ '2048x2048' ]);       // Remove Thumbnail (150 x 150 hard cropped)
  return $sizes;
}
add_filter( 'intermediate_image_sizes_advanced', 'remove_default_image_sizes' );


// completely disable image size threshold
add_filter( 'big_image_size_threshold', '__return_false' );
 
// increase the image size threshold to 4000px
function mynamespace_big_image_size_threshold( $threshold ) {
    return 2880; // new threshold
}
add_filter('big_image_size_threshold', 'mynamespace_big_image_size_threshold', 999, 1);



// Custom Image Settings
if( ! function_exists('junique_custom_image_sizes')  ):
function junique_custom_image_sizes() {
  // Bildgrößen
  add_image_size( 'gallery-thumbnail', 156, 117, false);
  add_image_size( 'avatar', 250, 250, true);
  add_image_size( 'nav-thumbnail', 200, 80, true);
}
add_action( 'after_setup_theme', 'junique_custom_image_sizes' );
endif;


//get the image size.
// do_action('qm/debug', get_intermediate_image_sizes());