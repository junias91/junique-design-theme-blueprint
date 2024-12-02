<?php
$defaults = array(
  'id'    => array(
    'section' => null,
  ),
  'class'	=> array(
    'section'	=> array("section-leistungen-teaser-nav", "leistungen-teaser-nav" ),
  ),
  'theme' => 'primary',
  'data'  => array(
    'heading_tag'     => 'h2',
    'post_type'       => 'leistungen',
    'posts_per_page'  => -1,
    'post_status'     => 'publish',
    'orderby'         => 'menu_order',
    'order'           => 'ASC',
    'taxonomy'        => 'leistungen-kategorie',
  )
);
$default_data = wp_parse_args_recursive($args, $defaults);
extract($default_data, EXTR_OVERWRITE);



$terms = get_terms(array(
  'taxonomy'   => $data['taxonomy'],
  'hide_empty' => true,
));
$grouped_posts = array();
if (!empty($terms) && !is_wp_error($terms)) {
  foreach ($terms as $term) {     
    $leistungen_args = array(
      'post_type'      => $data['post_type'],
      'posts_per_page' => $data['posts_per_page'],
      'post_status'    => $data['post_status'],
      'orderby'        => $data['orderby'],
      'order'          => $data['order'],
      'tax_query'      => array(
          array(
              'taxonomy' => $data['taxonomy'],
              'field'    => 'term_id',
              'terms'    => $term->term_id,
          ),
      ),
    );
    $leistungen = get_posts($leistungen_args);
    $grouped_posts[] = array(
      'term_id'   => $term->term_id,
      'name'      => $term->name,
      'slug'      => $term->slug,
      'posts'     => array_map(function($post) {
          return array(
            'id'    => $post->ID,
            'title' => $post->post_title,
            'url'   => get_permalink($post->ID),
          );
      }, $leistungen),
    );
  }
}


// do_action("qm/debug", $grouped_posts);

?>
<section id="<?php echo esc_attr($id['section']); ?>" <?php className($class['section']); ?> data-theme="<?php echo esc_attr($theme); ?>">
  <div class="container">    
    <?php if(!empty($data['title'])): ?>  
    <hgroup class="headline-group page-title">
      <p class="pre-title"><?php echo esc_html($data['sub_title']); ?></p>
      <<?php echo esc_attr($data['heading_tag']); ?>><?php echo esc_html($data['title']); ?></<?php echo esc_attr($data['heading_tag']); ?>>        
    </hgroup><!-- headline-group --><!-- row -->
    <?php endif; ?>
  </div><!-- container -->

  <?php 
  if (!empty($grouped_posts)):
  foreach ($grouped_posts as $group):
  ?>
  <div class="container leistungen-teaser-nav-container">
    <div class="row">

      <?php if($group['name']): ?>
      <div class="col-xs-12 col-md-3">
        <h2 class="tag-sub-headline --color-primary" id="kategorie-<?php echo esc_attr($group['slug']); ?>">
          <?php echo esc_html($group['name']); ?>
        </h2><!-- tag-sub-headline -->
      </div><!-- col-md-3 -->
      <?php endif; ?>

      <?php if (!empty($group['posts'])) : ?>
      <div class="col-xs-12 col-md-9">
        <nav class="content-teaser-nav-l">

          <?php 
          foreach($group['posts'] as $item): 
            
            $title        = $item['title'];
            $image        = get_the_post_thumbnail_url($item['id'], 'nav-thumbnail');
            $thumbnail_id = get_post_thumbnail_id($item['id']);
            $alt_text     = get_post_meta($thumbnail_id, '_wp_attachment_image_alt', true);
            $alt_text     = $alt_text ?: $item['title'];
            $url          = $item['url'];
            $link_text    = __("zur Leistungsseite", 'junique-design');

            $itme_class = array("content-nav-item-teaser");
            if($image) array_push($itme_class, "has-image");

          ?>
          <div <?php className($itme_class); ?>>
            
            <div class="nav-title">
              <h3><?php echo esc_html($title); ?></h3>
            </div><!-- nav-title -->
            
            <?php if(has_post_thumbnail($item['id'])): ?>
            <picture class="nav-image">
              <img src="<?php echo esc_url($image); ?>" alt="<?php echo esc_attr($alt_text); ?>" loading="lazy">
            </picture><!-- nav-image -->
            <?php endif; ?>

            <div class="nav-arrow">

            </div>

            <a class="nav-link" href="<?php echo esc_url($url); ?>" <?php echo custom_attributes(); ?>>
              <span class="screen-reader-text"><?php echo $link_text; ?></span> 
            </a>
          </div><!-- content-nav-item-teaser -->
          <?php endforeach; ?>

        </nav><!-- content-teaser-nav-l -->
      </div><!-- col-md-9 -->
      <?php endif; ?>

    </div><!-- row -->
  </div><!-- container -->
  <?php 
  endforeach;
  endif; 
  ?>

</section>