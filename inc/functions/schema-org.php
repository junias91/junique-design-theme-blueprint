<?php

if( !defined( 'ABSPATH' ) ) exit( 'Direct script access denied.' );


if( ! function_exists ('schema_meta_daten') ) :
function schema_meta_daten(){
  
  global $post;
  
  $schema = array(
    '@context'    => "https://schema.org",
    '@type'       => get_field('schema_type', 'options'),
    'name'        => get_bloginfo('name'),
    'url'         => get_home_url(),
    'telephone'   => '+49' . get_field('company_phone', 'options'), // change the country code
    'priceRange'  => get_field('schema_priceRange', 'options'),
    'address'     => array(
      '@type'           => 'PostalAddress',
      'streetAddress'   => get_field('address_street', 'option'),
      'postalCode'      => get_field('address_postal', 'option'),
      'addressLocality' => get_field('address_locality', 'option'),
      'addressRegion'   => get_field('address_region', 'option'),
      "addressCountry"  => get_field('address_country', 'option')
    )
  );


  // LOGO
  if ( get_field('company_logo', 'option') ) {
    $schema['logo'] = get_field('company_logo', 'option');
  }
  
  // IMAGE 1x1
  if ( get_field('company_image_1x1', 'option') ) {
    $schema['image'] = get_field('company_image_1x1', 'option');
  }
  
  // IMAGE 4x3
  if ( get_field('company_image_4x3', 'option') ) {
    $schema['image'] = get_field('company_image_4x3', 'option');
  }
  
  // IMAGE 16x9
  if ( get_field('company_image_16x9', 'option') ) {
    $schema['image'] = get_field('company_image_16x9', 'option');
  }
  
  // SOCIAL MEDIA
  if (have_rows('social_media', 'option')) {
    $schema['sameAs'] = array();
    while ( have_rows('social_media', 'option') ) : the_row();
      array_push($schema['sameAs'], get_sub_field('url'));
    endwhile;
  }

  // OPENING HOURS
  if (have_rows('opening_hours', 'option')) {
    
    $schema['openingHoursSpecification'] = array();
    
    while ( have_rows('opening_hours', 'option') ) : the_row();
      
      $closed = get_sub_field('closed');
      $from   = $closed ? '00:00' : get_sub_field('from');
      $to     = $closed ? '00:00' : get_sub_field('to');
      $openings = array(
        '@type'     => 'OpeningHoursSpecification',
        'dayOfWeek' => get_sub_field('days'),
        'opens'     => $from,
        'closes'    => $to
      );
      
      array_push($schema['openingHoursSpecification'], $openings);
    
    endwhile;

    /// VACATIONS / HOLIDAYS
    if ( have_rows('special_days', 'option') ) {
      
      while ( have_rows('special_days', 'option') ) : the_row();
      
      $closed    = get_sub_field('closed');
      $date_from = get_sub_field('date_from');
      $date_to   = get_sub_field('date_to');
      $time_from = $closed ? '00:00' : get_sub_field('time_from');
      $time_to   = $closed ? '00:00' : get_sub_field('time_to');
      
      $special_days = array(
        '@type'        => 'OpeningHoursSpecification',
        'validFrom'    => $date_from,
        'validThrough' => $date_to,
        'opens'        => $time_from,
        'closes'       => $time_to
      );
      
      array_push( $schema['openingHoursSpecification'], $special_days );
      
      endwhile;
    }
  }

  // CONTACT POINTS
  if (  get_field('contact', 'options') ) {
    
    $schema['contactPoint'] = array();
    
    while ( have_rows( 'contact', 'options' ) ) : the_row();
      
      $contacts = array(
        '@type'       => 'ContactPoint',
        'contactType' => get_sub_field('type'),
        'telephone'   => '+49' . get_sub_field('phone')
      );
      
      if ( get_sub_field('option' ) ) {
        $contacts['contactOption'] = get_sub_field('option');
      }
      
      array_push( $schema['contactPoint'], $contacts );
    
    endwhile;
    
  }
  
  $args = array( 'post_type' => 'kundenstimmen', 'posts_per_page' => -1 );
  $myposts = get_posts( $args );
  
  if( $myposts ){
    $n_page = wp_count_posts('kundenstimmen');
    $n_page_publish = $n_page->publish;
    $schema['aggregateRating'] = array();
    $schema_entrys = array(
      '@type'       => 'AggregateRating',
      'ratingValue' => '5',
      'reviewCount' => $n_page_publish
    );   
    array_push( $schema['aggregateRating'], $schema_entrys );
  }
  
 
  if( $myposts ){
    $schema['review'] = array();    
    foreach( $myposts as $post ){
      setup_postdata( $post ); 
      $k_review = array(
          '@type'         =>  'Review',
          'author'        =>  get_the_title(),
          'datePublished' =>  get_the_date('Y-m-d'),
          'name'          =>  get_the_title(),
          'reviewBody'    =>  get_the_content(),
          'reviewRating'  =>  array(
                '@type'       => 'Rating',
                'ratingValue' => '5'
          )
      );
      array_push(  $schema['review'] , $k_review );
    }
    wp_reset_postdata();
  }


  // add_global_schema_data($schema);
  
}
endif;
// add_action('wp_head', 'schema_meta_daten', 99);




add_filter( 'rank_math/json_ld', function( $data, $jsonld ) {
  
  // Prüfen, ob es sich um den Custom Post Type "person" handelt
  if ( 'person' !== get_post_type() ) {
      return $data;
  }

  // Hole die ACF-Felder für den aktuellen "person" Post
  $name = get_field('name');
  $job_title = get_field('job_title');
  $description = get_field('description');
  $image = get_field('image');

  // Baue das Schema für die "Person" auf
  $person_schema = [
      '@type' => 'Person',
      'name' => esc_attr($name),
      'jobTitle' => esc_attr($job_title),
      'description' => esc_attr($description),
  ];

  // Wenn ein Bild definiert wurde, füge es zum Schema hinzu
  if ( $image ) {
      $person_schema['image'] = esc_url($image['url']);
  }

  // Füge das Schema zur JSON-LD-Datenstruktur hinzu
  $data['person'] = $person_schema;

  return $data;
}, 10, 2 );



add_filter( 'rank_math/json_ld', function( $data, $jsonld ) {
  // Überprüfen, ob SearchAction im Schema existiert und entfernen
  if ( isset( $data['WebSite'] ) && isset( $data['WebSite']['potentialAction'] ) ) {
      foreach ( $data['WebSite']['potentialAction'] as $key => $action ) {
          if ( isset( $action['@type'] ) && 'SearchAction' === $action['@type'] ) {
              unset( $data['WebSite']['potentialAction'][$key] );
          }
      }
  }

  // Entfernt 'potentialAction' ganz, falls es leer ist
  if ( isset( $data['WebSite']['potentialAction'] ) && empty( $data['WebSite']['potentialAction'] ) ) {
      unset( $data['WebSite']['potentialAction'] );
  }

  return $data;
}, 10, 2 );