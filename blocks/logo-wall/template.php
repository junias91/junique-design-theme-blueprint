<?php
$defaults = array(
  'id'    => array(
    'section' => null,
  ),
  'class'	=> array(
    'section'	=> array("section-logo-wall"),
  ),
  'theme' => 'primary',
  'data'  => array(
    'post_type'           => "logo-wall",
    'post_status'         => "publish",
    'posts_per_page'      => -1,
    'orderby'             => "title",
    'order'               => "ASC",
  )
);
$default_data = wp_parse_args_recursive($args, $defaults);
extract($default_data, EXTR_OVERWRITE);

// do_action("qm/debug", $default_data);


$logo_args = array( 
  'post_type'           => $data['post_type'],
  'posts_per_page'      => $data['posts_per_page'],
  'post_status'         => $data['post_status'],
  'orderby'             => $data['orderby'],
  'order'               => $data['order']
);
// $logos = new WP_Query($logo_args);
$logos = get_posts($logo_args);

$logo_data = [];
if( $logos ){
  foreach( $logos as $item ){

    $ID = $item->ID;
    
    $args = array(
      'ID'          => $ID,
      'title'       => get_the_title($ID),
      'svg_code'    => get_field('svg', $ID) ?? null,
      'thumbnail'   => get_the_post_thumbnail($ID, 'logo') ?? null,
    );
    $logo_data[] = $args;

  } 
} 

// Array in 2 Teile aufteilen
$split_count = 2;
$array_splitt = splitArray($logo_data, 2);

?>
<section id="<?php echo esc_attr($id['section']); ?>" <?php className($class['section']); ?> data-theme="<?php echo esc_attr($theme); ?>">
  <div class="container">
    <div class="logo-wall-wrapper">
      <?php foreach($array_splitt as $stapel): ?>

      <div class="slider-track">

        <?php       
        foreach($stapel as $item): 
          $title        = $item['title'];
          $svg          = $item['svg_code'];
          $thumbnail    = $item['thumbnail'];
        ?>
          <?php if($svg || $thumbnail): ?>
          <div class="slider-item">
            <?php if($svg) echo $svg; ?>
          </div><!-- slider-item -->
          <?php endif; ?>
        <?php endforeach; ?>       
        
        <?php       
        foreach($stapel as $item): 
          $title        = $item['title'];
          $svg          = $item['svg_code'];
          $thumbnail    = $item['thumbnail'];
        ?>
          <?php if($svg || $thumbnail): ?>
          <div class="slider-item">
            <?php if($svg) echo $svg; ?>
          </div><!-- slider-item -->
          <?php endif; ?>
        <?php endforeach; ?>      
        
      </div><!-- slider-track -->

      <?php endforeach; ?>
    </div><!-- logo-wall-wrapper -->
  </div><!-- container -->
</section>