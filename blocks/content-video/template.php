<?php
$defaults = array(
  'id'    => array(
    'section' => null,
  ),
  'class'	=> array(
    'section'	=> array("section-content-video",  "section-video", "content-video"),
  ),
  'theme' => 'primary',
  'data'  => array(
    'video' => array(
      'aspect_ratio'    => '16:9'
    )
  )
);
$default_data = wp_parse_args_recursive($args, $defaults);
extract($default_data, EXTR_OVERWRITE);


// do_action("qm/debug", $default_data);


$video_title = !empty($data['video']['title']) ? $data['video']['title'] : null;
$video_caption = !empty($data['video']['caption']) ? $data['video']['caption'] : null;


$video_options = null;

$autoplay = $data['video']['autoplay'] ? 'autoplay ' : ''; 
$loop     = $data['video']['loop'] ? 'loop ' : ''; 
$controls = $data['video']['controls'] ? 'controls ' : '';
$preload  = $data['video']['preload'] ?? 'none';  
$mute     = $data['video']['mute'] ? ' muted ' : '';

$poster = $data['video']['image']['img_size_content_large'] ??  null;       

$preload_output = 'preload="'. $preload .'" ';
$poster_output  = 'poster="'.$poster.'" ';        

if($autoplay == 'yes') $autoplay .= ' playsinline muted ';

$controlsList_output  = 'controlsList="nodownload"';
$video_options .= $autoplay;
$video_options .= $loop;
$video_options .= $controls;
$video_options .= $mute;
$video_options .= $preload_output;
$video_options .= $poster_output;
$video_options .= $controlsList_output;

$video_psoter_large    = $data['video']['image']['img_size_content_large'] ?? null; 
$video_psoter_medium   = $data['video']['image']['img_size_content_medium'] ?? null; 

$video_wrapper         = array("video-wrapper");
$video_poster          = array("video-control-hide", "video-poster");
$video_video_wrapper   = array("video");

if($data['video']['aspect_ratio']){
  
  array_push($video_wrapper, "aspect-ratio");
  array_push($video_wrapper, "aspect-ratio-".$data['video']['aspect_ratio']);
  
  array_push($video_poster, "aspect-ratio");
  array_push($video_poster, "aspect-ratio-".$data['video']['aspect_ratio']);
  
  array_push($video_video_wrapper, "aspect-ratio");
  array_push($video_video_wrapper, "aspect-ratio-".$data['video']['aspect_ratio']);


}




?>
<section id="<?php echo esc_attr($id['section']); ?>" <?php className($class['section']); ?> data-theme="<?php echo esc_attr($theme); ?>">
  <div class="container">          

    <div <?php className($video_wrapper); ?> data-theme="<?php echo esc_attr($theme); ?>">

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

      <?php if(isset($data['badges']) && !empty($data['badges'])): ?>
      <div class="video-control-hide badge-wrapper">
        <?php foreach($data['badges'] as $badge): ?>
        <div class="badge">        
          <?php if($badge['list_title']): ?>
          <p class="badge-headline"><?php echo $badge['list_title']; ?></p>
          <?php endif; ?>
          <?php if($badge['list_content']): ?>
          <p><?php echo $badge['list_content']; ?></p>
          <?php endif; ?>
        </div><!-- badge -->
        <?php endforeach; ?>
      </div><!-- badge-wrapper -->
      <?php endif; ?>

      <div class="video-control-hide btn-play-wrapper">
        <button class="play-button"><svg><use xlink:href="#play"></use></svg><span class="screen-reader-text">Video abspielen</span></button>
      </div><!-- btn-play-wrapper -->

      <?php if($video_psoter_large): ?>
      <picture <?php className($video_poster); ?>>
        <img src="<?php echo esc_url($video_psoter_large); ?>" alt="<?php echo $video_title;?>" loading="lazy"> 
      </picture><!-- video-poster -->
      <?php endif; ?>
      
      <video <?php echo $video_options; ?> <?php className($video_video_wrapper); ?>>
        <source src="<?php echo esc_url($data['video']['hosted_url']['url']); ?>" type="video/mp4"> 
      </video>

    </div><!-- video-wrapper -->
  </div><!-- container -->
</section>