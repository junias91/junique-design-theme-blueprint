<?php 


function junique_design_block_category( $categories, $post ) {
	
	return array_merge(
		
		$categories,
		
		array(
      array(
				'slug' => 'junique-blocks',
				'title' => __( 'JUNIQUE Blocks', 'JUNQIUE Design Blocks' ),
			),

			array(
				'slug' => 'junique-parts',
				'title' => __( 'JUNIQUE Parts', 'JUNQIUE Design Blocks' ),
			),

		)
	
	);

}
add_filter( 'block_categories', 'junique_design_block_category', 10, 2);




/**
 * Gutenberg Settings 
 */
function mytheme_setup_theme_supported_features() {

	// Add support for editor styles.
	add_theme_support( 'editor-styles' ); 

	// Enqueue block editor stylesheet.
	add_editor_style( 'assets/css/gutenberg.css' );  

	add_theme_support( 'custom-units', 'px', 'rem', 'em', '%', 'vw', 'vh' );


	/*
	* Enable support for wide alignment class for Gutenberg blocks.
	*/
	add_theme_support( 'align-wide' );


	$args = array(
		array(
				'name' => __( 'Primary color', 'junique' ),
				'slug' => 'color-primary',
				'color' => '#003353',
		),
		array(
				'name' => __( 'Secondary color', 'junique' ),
				'slug' => 'color-secondary',
				'color' => '#000000',
		),
		array(
				'name' => __( 'Accent color', 'junique' ),
				'slug' => 'color-accent',
				'color' => '#003353',
		)
	);
	add_theme_support( 'editor-color-palette', $args );


	$args = array(
		array(
			'name'     => __( 'Vivid cyan blue to vivid purple', 'themeLangDomain' ),
			'gradient' => 'linear-gradient(135deg,rgba(6,147,227,1) 0%,rgb(155,81,224) 100%)',
			'slug'     => 'vivid-cyan-blue-to-vivid-purple'
		),
		array(
			'name'     => __( 'Vivid green cyan to vivid cyan blue', 'themeLangDomain' ),
			'gradient' => 'linear-gradient(135deg,rgba(0,208,132,1) 0%,rgba(6,147,227,1) 100%)',
			'slug'     =>  'vivid-green-cyan-to-vivid-cyan-blue',
		),
		array(
			'name'     => __( 'Light green cyan to vivid green cyan', 'themeLangDomain' ),
			'gradient' => 'linear-gradient(135deg,rgb(122,220,180) 0%,rgb(0,208,130) 100%)',
			'slug'     => 'light-green-cyan-to-vivid-green-cyan',
		),
		array(
			'name'     => __( 'Luminous vivid amber to luminous vivid orange', 'themeLangDomain' ),
			'gradient' => 'linear-gradient(135deg,rgba(252,185,0,1) 0%,rgba(255,105,0,1) 100%)',
			'slug'     => 'luminous-vivid-amber-to-luminous-vivid-orange',
		),
		array(
			'name'     => __( 'Luminous vivid orange to vivid red', 'themeLangDomain' ),
			'gradient' => 'linear-gradient(135deg,rgba(255,105,0,1) 0%,rgb(207,46,46) 100%)',
			'slug'     => 'luminous-vivid-orange-to-vivid-red',
		),
	);
	// add_theme_support( 'editor-gradient-presets', $args );


	$args = array(
		array(
			'name' => __( 'Klein', 'junique' ),
			'size' => 12,
			'slug' => 'small'
		),
		array(
			'name' => __( 'Normal', 'junique' ),
			'size' => 16,
			'slug' => 'regular'
		),
		array(
			'name' => __( 'Groß', 'junique' ),
			'size' => 36,
			'slug' => 'large'
		),
		array(
			'name' => __( 'Riesig', 'junique' ),
			'size' => 50,
			'slug' => 'huge'
		)
	);
	add_theme_support( 'editor-font-sizes', $args );

	add_theme_support('disable-custom-font-sizes');
	add_theme_support('disable-custom-colors');
	add_theme_support('disable-custom-gradients');

	// remove block patterns
	remove_theme_support( 'core-block-patterns' );

}

add_action( 'after_setup_theme', 'mytheme_setup_theme_supported_features' );







// ladet alle Blöcke automatisch
if( ! function_exists('include_blocks') ){
  function include_blocks($dir) {
    if (is_dir($dir)) {
      $files = scandir($dir);
      foreach ($files as $file) {
        if ($file != '.' && $file != '..') {
          $path = $dir . '/' . $file;
          if (is_dir($path)) {
            include_blocks($path);
          } elseif (basename($path) == 'init-gutenberg.php') {
            include_once $path;
          }
        }
      }
    }
  }
}