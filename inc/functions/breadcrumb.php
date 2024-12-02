<?php 


/**
 * Shows a breadcrumb for all types of pages.  This is a wrapper function for the Breadcrumb_Trail class,
 * which should be used in theme templates.
 *
 * @since  0.1.0
 * @access public
 * @param  array $args Arguments to pass to Breadcrumb_Trail.
 * @return void
 */
function breadcrumb_trail( $args = array() ) {

	$breadcrumb = apply_filters( 'breadcrumb_trail_object', null, $args );

	if ( ! is_object( $breadcrumb ) )
    $args = [
      'show_browse'   => false,
      'post_taxonomy' => ['product' => 'product_cat'],
    ];
    $breadcrumb = new JUNIQUE_Breadcrumb_Class( $args );

	return $breadcrumb->trail();
}