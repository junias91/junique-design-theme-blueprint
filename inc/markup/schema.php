<?php 

/**
 * Schema for <body> tag.
 */
if ( ! function_exists( 'junique_schema_body' ) ) :

	/**
	 * Adds schema tags to the body classes.
	 *
	 * @since 1.0.0
	 */
	function junique_schema_body() {

		if ( true !== apply_filters( 'junique_schema_enabled', true ) ) {
			return;
		}

		// Check conditions.
		$is_blog = ( is_home() || is_archive() || is_attachment() || is_tax() || is_single() ) ? true : false;

		// Set up default itemtype.
		$itemtype = 'WebPage';

		// Get itemtype for the blog.
		$itemtype = ( $is_blog ) ? 'Blog' : $itemtype;

		// Get itemtype for search results.
		$itemtype = ( is_search() ) ? 'SearchResultsPage' : $itemtype;
		
		// Get the result.
		$result = apply_filters( 'junique_schema_body_itemtype', $itemtype );

		// Return our HTML.
		echo apply_filters( 'junique_schema_body', "itemtype='https://schema.org/" . esc_attr( $result ) . "' itemscope='itemscope'" ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
endif;