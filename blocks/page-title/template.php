<?php 

$defaults = array(
  'class' => array(
    'section' => array("page-title"),
  ),
  'settings'  => array(
    'theme' => 'default',
    'section' => array(
      'sub_title' => true,
      'title'     => true,
      'content'   => true,
      'button'    => true 
    ),
    'headline_tag' => 'h2',
  )
);

$default_data = wp_parse_args_recursive($defaults, $args);
// $default_data = wp_parse_args($args, $defaults);
extract($default_data, EXTR_OVERWRITE );


// do_action("qm/debug", $default_data);
// do_action("qm/debug", $args);

?>

<hgroup <?php className($class['section']); ?>>

  <?php if( $settings['section']['sub_title'] === true && !empty($sub_title) ): ?>
  <p class="pre-title"><?php echo $sub_title; ?></p>
  <?php endif; ?>

  <?php if( $settings['section']['title'] === true && !empty($title) ): ?>
  <<?php echo $headline_tag; ?> class="reveal-type"><?php echo $title; ?></<?php echo $headline_tag; ?>>
  <?php endif; ?> 
  
  <?php if( $settings['section']['content'] === true && !empty($content)): ?>
  <div class="text-wrapper">
    <?php echo $content; ?>
  </div><!-- text-wrapper -->
  <?php endif; ?> 

</hgroup>