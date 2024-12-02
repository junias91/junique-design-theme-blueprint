<?php 


$defaults = array(
  'class' => array(
    'section' => array("jq-video", "video-wrapper"),
  ),
  'settings'  => array(
    'theme' => 'default',
    'section' => array(
      'video-controls'  => true,
      'options-left'    => true,
      'options-right'   => true,
      'timeline'        => true,
      'play-pause'      => true,
      'volume'          => true,
      'volume-slider'   => true,
      'video-timer'     => true,
      'playback-speed'  => true,
      'captions'        => true,
      'pic-in-pic'      => true,
      'theater'         => true,
      'fullscreen'      => true
    ),
    'cursor-icon'   => 'play',
    'cursor-color'  => 'color-accent',
    'aspect-ratio'  => '16-9',
  ),
  'data'  => array(
      'preload'   => '',
      'poster'    => THEME_URI ."/assets/img/ckin.jpg",
      'video'     => array(
          array(
              'src'   => THEME_URI . "/assets/video/01.mp4",
              'type'  => "video/mp4"
          ),
      ),
      'track'    => array(
          array(
              'src'       => THEME_URI . "/assets/video/01.vtt", 
              'srclang'   => 'de',
              'label'     => 'Deutsch', 
              'kind'      => 'subtitles',
              'default'   => true
          )
      )
  )
);
$default_data = wp_parse_args_recursive($defaults, $args);
extract($default_data, EXTR_OVERWRITE );
?>

<div <?php className($class['section']); ?> data-theme="<?= $settings['theme']; ?>">

  <button class="btn-play-glas"><svg><use xlink:href="#play"></use></svg></button>

  <?php if($settings['section']['video-controls'] === true ): ?>
  <div class="video-container">
    
    <?php if($settings['section']['timeline'] === true ): ?>
    <div class="video-timeline">
        <div class="progress-area">
            <span>00:00</span>
            <div class="progress-bar"></div><!-- progress-bar -->
        </div><!-- progress-area -->
    </div><!-- video-timeline -->
    <?php endif; ?>      
    <ul class="video-controls">
      <?php if($settings['section']['options-left'] === true ): ?>
        <li class="options left">
          
          <?php if($settings['section']['play-pause'] === true ): ?>
          <button class="play-pause" data-cursor="-opaque"><svg><use xlink:href="#play"></use></svg></button>
          <?php endif; ?>
          
          <?php if($settings['section']['volume'] === true ): ?>
          <button class="volume" data-cursor="-opaque"><svg><use xlink:href="#volume-high"></use></svg></button>
          <?php endif; ?>
          
          <?php if($settings['section']['volume-slider'] === true ): ?>
          <input class="volume-slider" type="range" min="0" max="1" value="1" step="any" data-cursor="-opaque">
          <?php endif; ?>
          
          <?php if($settings['section']['video-timer'] === true ): ?>
          <div class="video-timer">
            <p class="current-time">00:00</p>
            <p class="separator"> | </p>
            <p class="video-duration">00:00</p>
          </div><!-- video-timer -->
          <?php endif; ?>

      </li><!-- options -->
      <?php endif; ?>

      <?php if($settings['section']['options-right'] === true ): ?>
      <li class="options right">
        
        <?php if($settings['section']['playback-speed'] === true ): ?>
        <div class="playback-content">
          <button class="playback-speed" data-cursor="-opaque"><svg><use xlink:href="#speed"></use></svg></button>
          <ul class="speed-options">
            <li data-speed="2">2x</li>
            <li data-speed="1.5">1.5x</li>
            <li data-speed="1" class="active">Normal</li>
            <li data-speed="0.75">0.75x</li>
            <li data-speed="0.5">0.5x</li>
          </ul>
        </div>
        <?php endif; ?>
        
        <?php if($settings['section']['captions'] === true ): ?>
        <button class="captions" data-cursor="-opaque"><svg><use xlink:href="#captions"></use></svg></button>
        <?php endif; ?>
        
        <?php if($settings['section']['pic-in-pic'] === true ): ?>
        <button class="pic-in-pic" data-cursor="-opaque"><svg><use xlink:href="#pip"></use></svg></button>
        <?php endif; ?>

        <?php if($settings['section']['theater'] === true ): ?>
        <button class="theater" data-cursor="-opaque"><svg><use xlink:href="#theater-tall"></use></svg></button>
        <?php endif; ?>

        <?php if($settings['section']['fullscreen'] === true ): ?>
        <button class="fullscreen" data-cursor="-opaque"><svg><use xlink:href="#fullscreen"></use></svg></button>
        <?php endif; ?>

      </li><!-- options -->
      <?php endif; ?>

    </ul><!-- video-controls -->
  </div><!-- video-container -->
  <?php endif; ?>

  <video preload="none" poster="<?= THEME_URI; ?>/assets/img/ckin.jpg" data-cursor-icon-svg="play" data-cursor="color-accent" data-video-aspect-ratio="9/16">
    <source src="<?= THEME_URI; ?>/assets/video/01.mp4" type="video/mp4">
    <track src="<?= THEME_URI; ?>/assets/video/01.vtt" srclang="de" label="Deutsch" kind="subtitles" default>
  </video>

</div>