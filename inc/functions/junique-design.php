<?php

/**
 * JUNIQUE Design
 */
function junique_design_setup() {

  /**
	 * JUNIQUE Design 
	 * reset und optimize WordPress
	 */
	add_theme_support('wordpress-backend', array(
		'removeHelpTab'           => true,
		'removeNavSeperator'      => true,
		'changeFooterInfo'        => true,
		'removeUpdateInfo'        => true,
		'optimizeAdminBarSmall'   => true,
		'removeGreeting'          => true,
	)); 	
	
	add_theme_support('wordpress-post', array(
		// 'removeBlogging',
		'changeBlogName' => 'Magazin',
		// 'removeBlogTags',
		// 'removeBlogCategorys',
	));	
	
	add_theme_support('wordpress-page', array(
		'optimizeExerpt',
		'addExerpt',
		'addExerptWysiwyg',
		// 'addTagSupport',
		// 'addCategorySupport',
	));	
	
	add_theme_support('wordpress-search', array(
		'optimzeSerach',
		'removeSerach',
	)); 
	
	add_theme_support('wordpress-core', array(
		'removeWordPressVersion',
		//'removeFileVersion',
		'removeEmoji',
		'removeEmbed',
		'removeFeeds',
		'removeShortlinks',
		'removeWlwmanifest',
		'removeXmlrpc',
		// 'removeHeartbeat',
		// 'slowDownHeartbeat',
		'removeBodyClass',
		'addSelfClosingTags',
		'optimizeArchiveTitle',
		'removeGravatarSupport',
		'revisionLimit',
		'removeAuthorPage',
		'removeUpdates' => array(
			'core'          => true,
			'plugins'       => true,
			'theme'         => true,
			'emailSupport'  => true
		),
		//'blockExternalHTTP'
	)); 
	
	add_theme_support('gutenberg-remove', array(
		'removeGutenberg',
		'removeGutenbergAssets',
		'removeGutenbergWidgets',
	)); 
	
	// add_theme_support('relative-urls'); 	
	// add_theme_support('optimize-navbar');	
	//add_theme_support('optimize-css'); 	
	add_theme_support('remove-comments');
	add_theme_support('optimize-javascript', array(
		'deferJS',
		'removeJqueryMigrate',
		'removeJquery',
		'jqueryToFooter',
	)); 	
	add_theme_support('optimize-multimedia');
	add_theme_support('remove-api'); // reomve WordPress public API	
	
  // add_theme_support('junique-design-login'); // Login Page Plugin	
	// add_theme_support('optimize-wysiwyg'); // WYSIWYG Optimize	
	// add_theme_support('minify'); // HTML-Document minify
	
  add_theme_support('remove-html-comments'); // remove html comments from the dom <!-- LIKE THIS -->	
	add_theme_support('taxonomyCheckboxToRadiobox', array(
		'category',
		'faq_kategorien',
	)); // change a Checkbox to a radio box

}
add_action( 'after_setup_theme', 'junique_design_setup');