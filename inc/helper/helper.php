<?php 





// Get SVG Icon from Assets
if( !function_exists('get_svg_icon') ):
function get_svg_icon( string $icon_name = '', string $icon_pfad = '' ){
  if( empty($icon_pfad) ){
    $pfad = get_template_directory() .'/assets/icons/';
  }		
  $get_icon = $pfad.$icon_name.'.svg';		
  $icon = file_get_contents($get_icon);		
  if( empty( $icon ) ) return;
  return $icon;
  
}
endif;
if( !function_exists('get_svg_url') ):
function get_svg_url( string $icon_name = '', string $icon_pfad = '' ){
  if( empty($icon_pfad) ){
    $pfad = THEME_ASSETS .'/assets/icons/';
  }		
  $icon = $pfad.$icon_name.'.svg';				
  return $icon;    
}
endif;


/**
 * WordPress helper class
 * get attachment meta data
 * need id from image
 */
if ( !function_exists('wp_get_attachment') ) {
  function wp_get_attachment( $attachment_id = '' ){
    if( empty($attachment_id )) $attachment_id = get_post_thumbnail_id();
    $attachment = get_post( $attachment_id );
    return array(
      'alt' => get_post_meta( $attachment->ID, '_wp_attachment_image_alt', true ),
      'caption' => $attachment->post_excerpt,
      'description' => $attachment->post_content,
      'href' => get_permalink( $attachment->ID ),
      'src' => $attachment->guid,
      'title' => $attachment->post_title
    );
  }
}

/**
 * Set class like WordPress post_class
 */
if ( ! function_exists('className') ) {
  function className( $class = '' ) {
      // Wenn $class ein String ist, in ein Array umwandeln
      if ( is_string( $class ) ) {
          $class = explode( ' ', $class );
      }

      // Wenn $class kein Array ist oder leer, ein leeres Array setzen
      if ( ! is_array( $class ) || empty( $class ) ) {
          $class = [];
      }

      // Einzigartige und saubere Klassen sicherstellen
      $class = array_filter( array_unique( $class ) );

      echo 'class="' . esc_attr( implode( ' ', $class ) ) . '"';
  }
}

if( ! function_exists('html_class') ){
  function html_class( $class = array() ) {        
    if( is_user_logged_in() && is_admin_bar_showing()) {
      $user = wp_get_current_user();
      $roles = $user->roles;      
      array_push($class, 'logged-in-admin-bar');
      array_push($class, 'user-role-' . $roles[0]);      
    } 
    echo 'class="' . esc_attr( implode( ' ',  $class ) ) . '"';
  }
}

/**
 * Linked CSS file
 */
function enqueue_css($css_file_url, $method = 'inline') {
  // Methode zur Einbindung auswählen: 'inline', 'link', 'async'
  switch ($method) {
      case 'link':
          // CSS-Datei per <link> Tag einfügen
          echo '<link rel="stylesheet" href="' . $css_file_url . '" >';
          break;

      case 'async':
          // Asynchrones Laden der CSS-Datei
          echo '<link rel="preload" href="' . $css_file_url . '" as="style" onload="this.onload=null;this.rel=\'stylesheet\'">';
          echo '<noscript><link rel="stylesheet" href="' . $css_file_url . '"></noscript>';
          break;

      case 'inline':
      default:
          // Inhalt der CSS-Datei per URL abrufen
          $response = file_get_contents($css_file_url);
          
          // Prüfen, ob die Anfrage erfolgreich war
          if($response !== false) {
             
            // Inline-CSS im <head> ausgeben
            echo '<style>' . $response . '</style>';
              
          }
          break;
  }
}



/**
* Retrieve a post given its title.
*
* @uses $wpdb
*
* @param string $post_title Page title
* @param string $post_type post type ('post','page','any custom type')
* @param string $output Optional. Output type. OBJECT, ARRAY_N, or ARRAY_A.
* @return mixed
* @link         https://newbedev.com/how-do-i-get-a-post-page-or-cpt-id-from-a-title-or-slug
*/
function get_post_by_title($page_title, $post_type ='post', $output = OBJECT) {
  global $wpdb;
      $post = $wpdb->get_var( $wpdb->prepare( "SELECT ID FROM $wpdb->posts WHERE post_title = %s AND post_type= %s", $page_title, $post_type));
      if ( $post )
          return get_post($post, $output);

  return null;
}
function get_id_by_slug($page_slug) {
	$page = get_page_by_path($page_slug);
	if ($page) {
		return $page->ID;
	} else {
		return null;
	}
}
function the_slug_exists($post_name) {
	global $wpdb;
	if($wpdb->get_row("SELECT post_name FROM wp_posts WHERE post_name = '" . $post_name . "'", 'ARRAY_A')) {
		return true;
	} else {
		return false;
	}
}


// gibt alles Seiten aus und welche die nächste Seite ist
function get_all_pages(){

  $pages = get_pages(array(
    'sort_column' => 'menu_order'
  ));
  $page_array = array();
  $current_page_id = get_queried_object_id();
  $next_page = null;

  foreach ( $pages as $page ) {
    $page_array[] = array(
      'ID' => $page->ID,
      'post_title' => $page->post_title,
      'post_name' => $page->post_name,
      'guid' => get_permalink($page->ID)
    );
  }
  for ( $i = 0; $i < count( $page_array ); $i++ ) {
    if ( $page_array[$i]['ID'] == $current_page_id ) {
      if ( isset( $page_array[$i + 1] ) ) {
        $next_page = $page_array[$i + 1];
      }
      break;
    }
  }

  return $result = array(
    'all_pages' => $page_array,
    'next_page' => $next_page
  );

}

/**
 * gibt alle custom-post types als array zurück
 */
function get_all_cpt_array(){
  
  $args = array(
    'public'   => false
  );

  $output = 'names';
  $operator = 'and';

  $post_types = get_post_types( $args, $output, $operator );

  $post_types[] = '';


  // Entferne unerwünschte Post-Typen
  $exclude = array(
    'elementor_library', 
    'elementor_font',
    'elementor_icons',
    'elementor_snippet',
    'attachment', 
    'revision', 
    'nav_menu_item', 
    'custom_css', 
    'customize_changeset', 
    'oembed_cache', 
    'user_request', 
    'wp_block', 
    'wp_template', 
    'wp_template_part', 
    'wp_global_styles',
    'wp_navigation',
    'wp_font_family',
    'wp_font_face',    
    'acf-taxonomy',
    'acf-post-type',
    'acf-ui-options-page',
    'acf-field-group',
    'acf-field',
    'rank_math_schema',    
  ); 
  // Ersetzen Sie dies durch die Namen der CPTs, die Sie ausschließen möchten
  
  foreach ($exclude as $excluded_type) {
    if (($key = array_search($excluded_type, $post_types)) !== false) {
        unset($post_types[$key]);
    }
  }
  return $post_types;
}  



if ( ! function_exists( 'attach_template_to_page' ) ) :

  /**
  * Attaches the specified template to the page identified by the specified name.
  *
  * @params $page_name The name of the page to attach the template.
  * @params $template_path The template's filename (assumes .php' is specified)
  *
  * @returns -1 if the page does not exist; otherwise, the ID of the page.
  */

  function attach_template_to_page( $page_name, $template_file_name ) {

    // Look for the page by the specified title. Set the ID to -1 if it doesn't exist.
    // Otherwise, set it to the page's ID.
    $page = get_post_by_title( $page_name, OBJECT, 'page' );
    $page_id = null == $page ? -1 : $page->ID;

    // Only attach the template if the page exists
    if( -1 != $page_id ) {
      update_post_meta( $page_id, '_wp_page_template', $template_file_name );
    } // end if

    return $page_id;

  } // end attach_template_to_page
endif;


if (!function_exists('wp_parse_args_recursive')) {
  function wp_parse_args_recursive(array $args, array $defaults) {
      foreach ($defaults as $key => $value) {
          if (is_array($value) && isset($args[$key]) && is_array($args[$key])) {
              $args[$key] = wp_parse_args_recursive($args[$key], $value);
          } elseif (!isset($args[$key])) {
              $args[$key] = $value;
          }
      }
      return $args;
  }
}


// Funktion, die das Array in 2 oder 3 Teile aufteilt
if( ! function_exists('splitArray') ){
  function splitArray($array, $parts) {
    // Berechne die Größe jedes Teils
    $size = ceil(count($array) / $parts);
    // Teile das Array in die gewünschten Teile
    return array_chunk($array, $size);
  }
}



/**
 * Link-Attribute
 * Ein Link erhält alle Attribute.
 */
if( ! function_exists('custom_attributes') ){

  function custom_attributes(array $link = [], bool $has_schema = true): string {

    // Standard-Attribute für den Link
    $attributes = [
      'rel'  => 'follow',
      'href' => isset($link['url']) ? $link['url'] : '#',
    ];

    // Debugging
    // do_action("qm/debug", $attributes);

    // Externe Links behandeln
    if (!empty($link['is_external'])) {
        $attributes['target'] = '_blank';
    } else {
        $attributes['target'] = '_self';
    }


    // Nofollow/Follow behandeln
    if (!empty($link['nofollow'])) {
        $attributes['rel'] = 'nofollow';
    }

    if (!empty($link['is_external'])) {
      $attributes['rel'] .= ' noopener noreferrer';
    }
    

    // Benutzerdefinierte Attribute verarbeiten
    if (!empty($link['custom_attributes'])) {
        $customAttributes = explode(',', $link['custom_attributes']);
        foreach ($customAttributes as $attr) {
            $parts = explode('|', $attr);
            if (count($parts) === 2) {
                $attributes[trim($parts[0])] = trim($parts[1]);
            } elseif (count($parts) === 1) {
                $attributes[trim($parts[0])] = '';
            }
        }
    }

    // Schema.org-Attribute hinzufügen, wenn erforderlich
    if ($has_schema) {
        $attributes['itemprop'] = 'url';
        $attributes['itemscope'] = true;
        $attributes['itemtype'] = 'https://schema.org/Thing';
    }

    // Attribute in einen String konvertieren
    $attrString = '';
    foreach ($attributes as $key => $value) {
        if ($value === true) {
            $attrString .= htmlspecialchars($key) . ' ';
        } else {
            $attrString .= sprintf('%s="%s" ', htmlspecialchars($key), htmlspecialchars($value));
        }
    }

    return trim($attrString);
  }

}