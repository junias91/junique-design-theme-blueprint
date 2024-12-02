<?php 


/**
 * Add custom attribute to class or ACF option on menu element
 *
 * @author Junias Fenske
 * @link   https://junique.design
 */
function my_chat_menu_atts( $atts, $item, $args ) {

	// Hole ACF-Felder
	$open_modal           = get_field('has-a-dropdown', $item->ID);
	$target_dropdwon_id   = get_field('target_dropdwon', $item->ID);

	// Prüfen, ob das Ziel existiert und gültig ist
	if ( $open_modal && !empty($target_dropdwon_id) ) {
			// Hole das WP_Post-Objekt basierend auf der ID
			$target_post = get_post($target_dropdwon_id);

			// Prüfen, ob das Post-Objekt existiert
			if ( $target_post ) {
					$atts['data-toggle-class'] = 'active';
					$atts['data-toggle-target'] = 'modal-'. $target_post->ID;
					$atts['data-toggle-abort'] = 'escape clickout';
					$atts['data-toggle-scroll-lock'] = 'true';
			}
	}

	return $atts;
}
add_filter( 'nav_menu_link_attributes', 'my_chat_menu_atts', 10, 3 );





function add_heading_to_menu_items($items, $args) {
  foreach ($items as &$item) {
      // Prüfen, ob der Menüpunkt eine Überschrift sein soll
      $is_heading = get_field('is_headline', $item->ID);      
      if ($is_heading) {
          
          // Füge die Klasse 'is-heading' zum <li> hinzu
          $item->classes[] = 'is-heading';
          $item->classes[] = 'li-headline';
          // Setze den Titel ohne URL in ein <p>-Tag mit Klasse 'menu-header'
          $item->title = '<p class="menu-header">' . esc_html($item->title) . '</p>';
          // Setze die URL und den Typ auf leer, um das <a>-Tag zu entfernen
          $item->url = '';
          $item->type_label = 'custom';
          $item->type = 'custom';
          $item->remove_link = true; // Custom Property to use in walker
      }
  }    
  return $items;
}
add_filter('wp_nav_menu_objects', 'add_heading_to_menu_items', 10, 2);



/**
 * Navigationen werden im Frontend angezeigt
 */
if( ! function_exists('junique_custom_menu') ){

  function junique_custom_menu(){

    $args = array(
      'post_type'       => 'junique-navigation',
      'posts_per_page'  => -1,
      'orderby'         => 'menu_order',
      'sort_order'      => 'asc',
      'tax_query' => array(
        array(
          'taxonomy' => 'navigation-kategorie',
          'field'    => 'slug',
          'terms'    => 'header'
        )
      )
    );
    $navis = get_posts( $args );

    if( ! $navis) return; 
      
    foreach($navis as $navi){

      $post_id =  $navi->ID;
      $modal_id = 'modal-'.$post_id;

      // soll der Menü Titel angezeigt werden?
      $show_menu_title = get_field('show_menu_title', $post_id);
      $show_footer_copyright = get_field('show_footer_copyright', $post_id);
      $show_custom_footer_text = get_field('show_custom_footer_text', $post_id);
      $footer_text = get_field('footer_text', $post_id);

      $menu_footer_text = get_field('footer_text', $post_id);
      $show_social_media_menu = get_field('show_social_media_menu', $post_id);

      // do_action("qm/debug", $show_social_media_menu);

      $wp_nav_manu_id = get_field('wp_navigation', $post_id);
      $menu_object = wp_get_nav_menu_object($wp_nav_manu_id);


      ?>
      <menu class="modal menu-modal" data-toggle-name="<?= $modal_id; ?>" data-toggle-class="active">
      <div class="modal-bg" data-toggle-target="<?= $modal_id; ?>" data-toggle-class="active"></div><!-- modal-bg -->
      <div class="modal-wrapper menu-modal-inner modal-inner">
      <div class="menu-wrapper">
      
      <div class="menu-top">       
        <div class="menu-modal-toggles header-toggles <?php if($show_menu_title === true) echo "has-navbar-headline"; ?>">     
         
          <div class="toggle-back">
            <button class="btn-toggle-back" data-toggle-target="<?= $modal_id; ?>" data-toggle-class="active">
              <?php _e('Zurück', 'blueprint'); ?>          
            </button>
          </div>

          <?php
          if($show_menu_title === true){
            echo '<p class="navbar-headline">';
            echo $menu_object->name;
            echo '</p>';
          }
          ?>   
        
          <button class="toggle toggle-back" data-toggle-target="<?= $modal_id; ?>" data-toggle-class="active">
            <?php _e('Close', 'blueprint'); ?>
            <div class="menu-burger" data-toggle-name="<?= $modal_id; ?>" data-toggle-class="active">
              <span></span>
              <span></span>					
            </div><!-- #menu-burger -->
          </button>
        </div>      

      <?php 
      if($menu_object){      
        $defaults = array(
          'menu'            => $wp_nav_manu_id,
          'container'       => null,
          'container_class' => null,
          'container_id'    => null,
          'menu_id'         => null,
          'menu_class'      =>'navigation ' . $menu_object->slug,
          'fallback_cb'     => 'wp_bootstrap_navwalker::fallback',
          'walker'          => new wp_bootstrap_navwalker()
        );	
        wp_nav_menu( $defaults );
      }
      ?>
      </div><!-- .menu-top -->

      <div class="menu-bottom">

        <p class="menu-copyright">
          <?php if($show_footer_copyright === true): ?>
          &copy; <?php echo esc_html( date( 'Y' ) ); ?> <a href="<?php echo esc_url( home_url() ); ?>"><?php echo bloginfo( 'name' ); ?></a>
          <?php endif; ?>   
          <?php if($show_custom_footer_text === true && !empty($footer_text)): ?>          
            <?php echo $footer_text; ?>
          <?php endif; ?>
        </p>
        

        <?php 
        if($show_social_media_menu === true){
          social_media_menu(); 
        }
        ?>
        

      </div><!-- menu-bottom -->

      </div>
      </div>
      </menu><!-- modal menu-modal -->
      <?php
    }    


  }

}