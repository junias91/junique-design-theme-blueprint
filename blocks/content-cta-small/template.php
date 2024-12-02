<?php
$defaults = array(
  'id'    => array(
    'section' => null,
  ),
  'class'	=> array(
    'section'	=> array("section-content-cta-small", "content-cta-small"),
  ),
  'theme' => 'primary',
  'data'  => array(
    'title' => 'Sprechen Sie uns an, wir helfen Ihnen gerne weiter!'
  )
);
$default_data = wp_parse_args_recursive($args, $defaults);
extract($default_data, EXTR_OVERWRITE);

// do_action("qm/debug", $default_data);


?>
<section id="<?php echo esc_attr($id['section']); ?>" <?php className($class['section']); ?> data-theme="<?php echo esc_attr($theme); ?>">
  <div class="container">

  <div class="inner-container-content-cta-small">
  
    <?php if($data['title']): ?>
    <p><?php echo $data['title']; ?></p>
    <?php endif; ?>

    <?php if (!empty($data['buttons'])): ?>
    <div class="btn-wrapper">
      <?php             
      foreach ($data['buttons'] as $button):    
        $title = $button['title'] ?? null; 
        $link =  $button['link'] ?? null;      
      ?>
      <?php if(!empty($link['url']) && !empty($title)): ?>
      <a class="btn-link-1" <?php echo custom_attributes($link); ?>>
        <span><?php echo esc_html($title); ?></span>
        <div class="arrow"></div>
      </a><!-- btn-link-1 -->
      <?php endif; ?>

      <?php endforeach; ?>          
    </div><!-- btn-wrapper -->
    <?php endif; ?>

  </div><!-- inner-container-content-cta-smal -->

  </div><!-- container -->
</section>