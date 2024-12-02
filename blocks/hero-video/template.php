<?php
$defaults = array(
  'id'    => array(
    'section' => null,
  ),
  'class'	=> array(
    'section'	=> array("section-hero-video", "section-video", "hero-video", "hero-image", "hero-video-image"),
  ),
  'theme' => 'primary',
  'data'  => array(
    'heading_tag' => 'h2',
  )
);
$default_data = wp_parse_args_recursive($args, $defaults);
extract($default_data, EXTR_OVERWRITE);

// do_action("qm/debug", $default_data);

$video_title    = !empty($data['video']['title']) ? $data['video']['title'] : null;
$video_caption  = !empty($data['video']['caption']) ? $data['video']['caption'] : null;
?>
<section id="<?php echo esc_attr($id['section']); ?>" <?php className($class['section']); ?> data-theme="<?php echo esc_attr($theme); ?>">
  <div class="container">
    <div class="row">
      <div class="col-xs-12 col-md-7">
        <?php if(!empty($data['title'])): ?>
        <hgroup class="headline-group">
          <<?php echo esc_attr($data['heading_tag']); ?>><?php echo esc_html($data['title']); ?></<?php echo esc_attr($data['heading_tag']); ?>>
        </hgroup><!-- headline-group -->
        <?php endif; ?>
      </div><!-- col-xs-12 col-md-7 -->
      <div class="col-xs-12 col-md-5">          
        <div class="headline-content-wrapper">       
          <?php if($data['headline_content']) echo $data['headline_content']; ?>
          <?php if (!empty($data['button-repeater'])): ?>
          <div class="btn-wrapper">
            <?php             
            foreach ($data['button-repeater'] as $button): 
              // do_action("qm/debug",$button);
              $has_arrow      = $button['use_arrow'];
              $has_icon       = $button['use_icon'];
              $fill_type      = $button['block_type_layout']; 
              $btn_fill       = null;             

              switch($fill_type){
                case "fill":
                  $btn_fill = 'btn-';                 
                  break;
                case "outline":
                  $btn_fill = 'btn-outline-';
                  break;
                case "link":
                  $btn_fill = 'btn-link-'; ;
                  break;
              }
              if(!empty($button['button_color'])){
                $final_btn_fill = $btn_fill.$button['button_color'];
              }     
              
            ?>
            <?php if(!empty($button['button_url']['url']) && !empty($button['button_title'])): ?>
            <a class="btn <?php echo $final_btn_fill; ?>" <?php echo custom_attributes($button['button_url']); ?>>
              <?php if($button['use_icon'] === 'yes' && $button['icon_position'] == 'left' ): ?>                
                <?php if($button['icon_type'] === 'icon' && !empty($button['icon_icon'])): ?>
                <i class="<?php echo $button['icon_icon']['library'] . ' '. $button['icon_icon']['value']; ?>"></i>
                <?php endif; ?>
              <?php endif; ?>
              <span><?php echo esc_html($button['button_title']); ?></span>
              <?php if ( $button['use_icon'] && $button['icon_position'] == 'right' ): ?>
                <?php if($button['icon_type'] === 'icon' && !empty($button['icon_icon'])): ?>
                <i class="<?php echo $button['icon_icon']['library'] . ' '. $button['icon_icon']['value']; ?>"></i>
                <?php endif; ?>
              <?php endif; ?>
              <?php if($has_arrow === 'yes'): ?>
              <div class="arrow"></div>
              <?php endif; ?>
            </a><!-- button -->
            <?php endif; ?>
            <?php endforeach; ?>          
          </div><!-- btn-wrapper -->
          <?php endif; ?>
        </div><!-- headline-content-wrapper -->
      </div><!-- col-xs-12 col-md-5 -->
    </div><!-- row -->
    <?php 
    $video_options = null;
    if (!empty($data['video']['hosted_url'])):       

      $autoplay = $data['video']['autoplay'] ? 'autoplay ' : ''; 
      $loop     = $data['video']['loop'] ? 'loop ' : ''; 
      $controls = $data['video']['controls'] ? 'controls ' : '';
      $preload = $data['video']['preload'] ?? 'none';  
      
      $poster = $data['video']['image']['img_size_content_large'] ??  null;       
      
      $preload_output = 'preload="'. $preload .'" ';
      $poster_output  = 'poster="'.$poster.'" ';        

      $controlsList_output  = 'controlsList="nodownload"';
      $video_options .= $autoplay . ' playsinline muted ';
      $video_options .= $loop;
      $video_options .= $controls;
      $video_options .= $preload_output;
      $video_options .= $poster_output;
      $video_options .= $controlsList_output;

      $video_psoter_large = $data['video']['image']['img_size_content_large'] ?? null; 
      $video_psoter_medium = $data['video']['image']['img_size_content_medium'] ?? null; 

    ?>
    <div class="video-wrapper" data-theme="<?php echo esc_attr($theme); ?>">
      <?php if($video_title): ?>
      <div class="video-control-hide video-title">
        <p><?php echo $video_title;?></p>
      </div><!-- video-title -->
      <?php endif; ?>

      <?php if($video_caption): ?>
      <div class="video-control-hide video-caption">
        <div class="badge-container">
          <div class="inner-container">
            <p><?php echo $video_caption; ?></p>
          </div>
        </div><!-- badge-container -->
      </div><!-- video-caption -->
      <?php endif; ?>
      <?php if(isset($data['badges']) && !empty($data['badges']) && !empty($data['show_video_badge']) && $data['show_video_badge'] === 'yes' ): ?>
      <div class="video-control-hide badge-wrapper">
      <?php 
      $count_items = 0;
      foreach($data['badges'] as $badge): 
        $count_items++;
        $type = ($count_items % 2 == 0) ? $rellax_spped = 1.1 : $rellax_spped = 0.85; 
      ?>
        <?php if(!empty($badge['list_title']) || !empty($badge['list_content'])):?>
        <div class="badge" data-rellax-y data-rellax-speed="<?php echo $rellax_spped; ?>" data-rellax-percentage="0">                  
          <?php if(!empty($badge['list_title'])): ?>
          <p class="badge-headline"><?php echo $badge['list_title']; ?></p>
          <?php endif; ?>
          <?php if(!empty($badge['list_content'])): ?>
          <p><?php echo $badge['list_content']; ?></p>
          <?php endif; ?>
        </div><!-- badge -->
        <?php endif; ?>

      <?php endforeach; ?>
      </div><!-- badge-wrapper -->
      <?php endif; ?>

      <div class="video-control-hide btn-play-wrapper">
        <button class="play-button"><svg><use xlink:href="#play"></use></svg><span class="screen-reader-text">Video abspielen</span></button>
      </div><!-- btn-play-wrapper -->

      <?php if($video_psoter_large): ?>
      <picture class="video-control-hide video-poster">
        <img src="<?php echo esc_url($video_psoter_large); ?>" alt="<?php echo $video_title;?>" loading="lazy"> 
      </picture><!-- video-poster -->
      <?php endif; ?>
      <?php if($data['video']['hosted_url']['url']): ?>
      <video <?php echo $video_options; ?> >
        
        <source src="<?php echo esc_url($data['video']['hosted_url']['url']); ?>" type="video/mp4"> 
        
        <?php 
        if($data['video']['subtitles']):
          $subtitles_count = 0;
          foreach($data['video']['subtitles'] as $item):
            $subtitles_count++;
            $srclang_label = $item['srclang_label'] ?? null;
            $srclang = $item['srclang'] ?? null;
            $subtitles = $item['subtitles'] ?? null;
            // do_action("qm/debug", $subtitles);
            
        ?>
        <?php if($subtitles['url']): ?>
        <track src="<?php echo $subtitles['url']; ?>" srclang="<?= $srclang; ?>" label="<?= $srclang_label; ?>" kind="subtitles" <?php if($subtitles_count === 1) echo "default"; ?>>
        <?php endif; ?>
        <?php 
        endforeach; 
        endif; ?>
        
      </video>
      <?php endif; ?>
    </div><!-- video-wrapper -->
    <?php endif; ?>
  </div><!-- container -->
</section>