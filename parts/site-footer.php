<?php

$defaults = array(
  'theme'			=> 'default', // primary, secondary, accent, Black, white
  'class'	=> array(
    'section'	=> array("site-footer"),
  ),
  'date'                => date_i18n('Y'),
  'footer_infos_show'   => true,  
  'footer_cta_show'     => get_field('footer_cta_show', 'options') ?? true,
  'footer_cta_text'     => get_field('footer_cta_text', 'options') ?? '<p>Lasst uns etwas<br>Großartiges schaffen!</p>',
  'footer_cta_link'     => get_field('footer_cta_link', 'options'),
  'privacy_policy_id'   => get_option('wp_page_for_privacy_policy'),
  'privacy_policy_url'  => null,
  'company_name'        => get_field('company_name', 'options'),
  'address_street'      => get_field('address_street', 'options'),
  'address_postal'      => get_field('address_postal', 'options'),
  'address_locality'    => get_field('address_locality', 'options'),
  'address_country'     => get_field('address_country', 'options'),
  'company_phone'       => get_field('company_phone', 'options'),
  'company_email'       => get_field('e_mail_adresse', 'options'),
  'company_telefax'     => get_field('company_telefax', 'options'),
  'schedule'            => get_field('opening_hours', 'options'),
  'ansprechpartner'     => get_field('person', 'options'),
  'show_company_section_adresse'  => get_field('show_company_section_adresse', 'options'),
  'show_company_section_kontakt'  => get_field('show_company_section_kontakt', 'options'),
  'company_section_kontakt_headline'  => get_field('company_section_kontakt_headline', 'options') ?? 'Kontakt',
  'show_company_section_schedule'  => get_field('show_company_section_schedule', 'options'),
  'company_section_schedule_headline'  => get_field('company_section_schedule_headline', 'options') ?? 'Erreichbarkeit',
  'show_company_section_contact_person'  => get_field('show_company_section_contact_person', 'options'),
  'company_section_contact_person_id'  => get_field('company_section_contact_person_id', 'options'),
  'company_section_contact_person_headline'  => get_field('company_section_contact_person_headline', 'options') ?? 'Ansprechpartner',
);

$data = wp_parse_args($args, $defaults);
extract($data, EXTR_OVERWRITE );


// Datenschutz URL
if(empty($privacy_policy_id)) {  
  $privacy_policy_id = get_id_by_slug('meta/datenschutzerklaerung');
  if(empty($privacy_policy_id) ) $privacy_policy_id = get_id_by_slug('datenschutzerklaerung');
  if($privacy_policy_id) $privacy_policy_url = get_permalink($privacy_policy_id);
}else{
  $privacy_policy_url = get_permalink($privacy_policy_id);
}

// Ansprechperson
if($company_section_contact_person_id){
  
  $person_id = $company_section_contact_person_id->ID;
  $person = array(
    'id'              => $person_id,
    'anrede'          => get_field('anrede',$person_id),
    'vorname'         => get_field('vorname',$person_id),
    'nachname'        => get_field('nachname',$person_id),
    'telefonnummer'   => get_field('telefonnummer',$person_id),
    'e-mail-adresse'  => get_field('e-mail-adresse',$person_id),
    'position'        => get_field('position',$person_id),
    'company'         => get_field('company',$person_id),
    'company_street'  => get_field('street',$person_id),
    'company_zipCode' => get_field('zipCode',$person_id),
    'company_city'    => get_field('city',$person_id),
    'company_country' => get_field('addressCountry',$person_id),
  );
  // Volle Name mit Anrede wird generiert
  $person_anrede_name = null;
  if($person['anrede']){
    $person_anrede_name = $person['anrede']['label'];
    if($person['vorname']) $person_anrede_name .= " " . $person['vorname'];
    if($person['nachname']) $person_anrede_name .= " " . $person['nachname'];
  }else{
    if($person['vorname']) $person_anrede_name = $person['vorname'];
    if($person['nachname']) $person_anrede_name .= " " . $person['nachname'];
  }

}

?>
<footer itemscope itemtype="https://schema.org/WPFooter" id="site-footer" class="site-footer" data-theme="<?= $theme; ?>"> 
  <div class="container">  
    <?php if($footer_cta_show == true): ?>
    <div class="row">
      <div class="col-xs-12 footer-cta">
        <?php if($footer_cta_link['url']): ?>  
        <a href="<?php echo esc_url($footer_cta_link['url']); ?>" target="<?php if($footer_cta_link['target']): echo esc_attr($footer_cta_link['target']); else: echo '_self'; endif; ?>">
        <?php endif; ?>

          <?php echo $footer_cta_text; ?>
          
          <?php if($footer_cta_link['url']): ?>  
          <p class="footer-cta-text-button">
            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#fff"><path d="m216-160-56-56 464-464H360v-80h400v400h-80v-264L216-160Z"/></svg>
            <span><?php echo esc_html($footer_cta_link['title']); ?></span>
          </p>
          <?php endif; ?>

          <?php if($footer_cta_link['url']): ?>  
          </a>
          <?php endif; ?>

      </div><!-- footer-cta -->
    </div><!-- row -->    
    <hr>
    <?php endif; ?>

    <?php if($footer_infos_show == true): ?>
    <div class="row">

      <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">

        <div class="widget-newsletter">
          <p class="widgete-title">Seien Sie der Erste, der die neuesten Nachrichten über Trends, Inspiration und mehr erhält</p>          
          <form action="<?php home_url(); ?>" method="POST">
            <label for=""><?php _e('E-Mail-Addresse', 'blueprint'); ?></label>
            <div class="form-group">
              <input type="email" name="email" placeholder="Gib hier deine E-Mail-Adresse ein">
              <button type="submit">
                <svg width="24" height="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                  <path d="M3.41406 4.00781L3.74219 5.41406L5.19531 12L3.74219 18.5859L3.41406 19.9922L4.75 19.4531L21.25 12.7031L22.961 12L21.25 11.2969L4.75 4.54688L3.41406 4.00781ZM5.5 6.49219L17.1485 11.25H6.55469L5.5 6.49219ZM6.55469 12.75H17.1485L5.5 17.5078L6.55469 12.75Z" />
                </svg>
                <span class="screen-reader-text"><?php _e('zum newsletter anmelden', 'blueprint'); ?></span>              
              </button>
            </div><!-- form-group -->
            <p>Wenn Sie sich anmelden, akzeptieren Sie unsere <a href="<?php echo esc_url($privacy_policy_url); ?>">Datenschutzbestimmungen.</a></p>
          </form>
        </div><!-- widget-newsletter -->      

      </div><!-- col-xs-12 col-sm-12 col-md-4 -->
      <div class="col-xs-12 hr-mobile"><hr></div>

      <div class="col-xs-12 col-sm-12 col-md-12 col-lg-offset-1 col-lg-7 ">
        <div class="row footer-company-infos">

          <?php if($show_company_section_adresse == true): ?>
          <div class="col-xs-12 col-sm-6">
            <div class="widget-footer-info-icon info-icon-item">
              <div class="icon-base">
                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px"><path d="M480-400 40-640l440-240 440 240-440 240Zm0 160L63-467l84-46 333 182 333-182 84 46-417 227Zm0 160L63-307l84-46 333 182 333-182 84 46L480-80Z"/></svg>
              </div><!-- icon-base -->
              <div class="content-wrapper">
                <p class="widget-title"><?php echo esc_html($company_name); ?></p>
                <p><?php echo esc_html($address_street); ?>,<?php echo esc_html($address_postal); echo " " . esc_html($address_locality); ?></p>
                <?php office_status_widget(); ?>
              </div><!-- content-wrapper -->
            </div><!-- widget-footer-info-icon -->
          </div><!-- col-xs-12 col-sm-6 -->
          <?php endif; ?>

          <?php if($show_company_section_kontakt == true): ?>
          <div class="col-xs-12 col-sm-6">
            <div class="widget-footer-info-icon info-icon-item">
              <div class="icon-base">
                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px"><path d="M760-482q0-117-81.5-198.5T480-762v-80q75 0 140.5 28.5t114 77q48.5 48.5 77 114T840-482h-80Zm-160 0q0-50-35-85t-85-35v-80q83 0 141.5 58.5T680-482h-80Zm198 362q-125 0-247.5-54T328-328Q228-428 174-550t-54-248v-42h236l37 201-114 115q22 39 49 74t58 65q29 29 63.5 55.5T524-280l116-116 200 41v235h-42Z"/></svg>
              </div><!-- icon-base -->
              <div class="content-wrapper">
                <p class="widget-title"><?php if($company_section_kontakt_headline) echo $company_section_kontakt_headline; ?></p>
                <div class="content-tabel">
                  <header class="table-header">
                    <?php if($company_phone): ?>
                    <p>Telefon:</p>
                    <?php endif; ?>
                    <?php if($company_telefax): ?>
                    <p>Fax:</p>
                    <?php endif; ?>
                  </header>         
                  <footer class="table-content">
                    <?php if($company_phone): ?>
                    <p>+49(0)4471 840 96-96</p> 
                    <?php endif; ?>
                    <?php if($company_telefax): ?>
                    <p>+49(0)4471 840 96-99</p>
                    <?php endif; ?>
                  </footer>         
                </div><!-- content-tabel -->

              </div><!-- content-wrapper -->
            </div><!-- widget-footer-info-icon -->
          </div><!-- col-xs-12 col-sm-6-->
          <?php endif; ?>

          <?php if($show_company_section_schedule == true ): ?>
          <div class="col-xs-12 col-sm-6">
            <div class="widget-footer-info-icon">
              <div class="icon-base">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960"><path d="M360-840v-80h240v80H360Zm80 440h80v-240h-80v240Zm40 320q-74 0-139.5-28.5T226-186q-49-49-77.5-114.5T120-440q0-74 28.5-139.5T226-694q49-49 114.5-77.5T480-800q62 0 119 20t107 58l56-56 56 56-56 56q38 50 58 107t20 119q0 74-28.5 139.5T734-186q-49 49-114.5 77.5T480-80Z"/></svg>
              </div><!-- icon-base -->
              <div class="content-wrapper">
                <p class="widget-title"><?php echo $company_section_schedule_headline; ?></p>
                <div class="content-tabel">
                  <header class="table-header">
                  <?php
                  foreach ($schedule as $item) {
                    $days = $item['days'];
                    $from = $item['from'];
                    $to = $item['to'];
                    $closed = $item['closed'];
                    if (count($days) > 1) {
                      $days_output = $days[0] . '. - ' . end($days) . '.';
                    } else {
                      $days_output = implode(', ', $days) . '.';
                    }
                    echo "<p>" . esc_html($days_output) . "</p>";
                  }
                  ?>
                  </header><!-- table-header -->
                  <footer class="table-content">
                  <?php 
                  foreach ($schedule as $item) {
                    if (!empty($item['closed'])) {
                      echo '<p>Geschlossen</p>';
                    } else {
                      echo '<p>' . esc_html($item['from']) . ' - ' . esc_html($item['to']) . ' Uhr</p>';
                    }
                  }
                  ?>
                  </footer><!-- table-content -->      
                </div><!-- content-tabel -->            
              </div><!-- content-wrapper -->
              </div><!-- widget-footer-info-icon -->
          </div><!-- col-xs-12 col-sm-6 -->
          <?php endif; ?>

          <?php if($show_company_section_contact_person == true): ?>
          <div class="col-xs-12 col-sm-6">
            <div class="widget-footer-info-icon last-child">
              <div class="icon-base">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960"><path d="M320-400h320v-22q0-44-44-71t-116-27q-72 0-116 27t-44 71v22Zm160-160q33 0 56.5-23.5T560-640q0-33-23.5-56.5T480-720q-33 0-56.5 23.5T400-640q0 33 23.5 56.5T480-560ZM80-80v-800h800v640H240L80-80Z"/></svg>
              </div><!-- icon-base -->
              <div class="content-wrapper">
                <p class="widget-title"><?php echo $company_section_contact_person_headline; ?></p>
                <p><strong><?php echo $person_anrede_name; ?></strong><?php if($person['position']) echo "<br>" . $person['position']; ?></p>
              </div><!-- content-wrapper -->
            </div><!-- widget-footer-info-icon -->
          </div><!-- col-xs-12 col-sm-6 -->
          <?php endif; ?>

        </div>
      </div><!-- .col-xs-12 col-sm-12 col-md-offset-1 col-md-7 -->
    </div><!-- row --> 
    <hr class="hr-hide-mobile">
    <?php endif; ?>

    <div class="row sub-footer">     
      <div class="col-xs-12 col-md-offset-1 col-md-7 footer_menu_wrapper">
        <?php footer_menu(); ?>
      </div><!-- footer_menu_wrapper -->
      <div class="col-xs-12 col-sm-12 col-md-4 footer_widget_right">
        <div class="widget-reviews">
          <header class="top">
            <svg width="60" height="20" viewBox="0 0 60 20" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M26.1765 10.525C26.1765 13.4024 23.9535 15.5228 21.2254 15.5228C18.4973 15.5228 16.2744 13.4024 16.2744 10.525C16.2744 7.62731 18.4973 5.52726 21.2254 5.52726C23.9535 5.52726 26.1765 7.62731 26.1765 10.525ZM24.0091 10.525C24.0091 8.7269 22.7207 7.49662 21.2254 7.49662C19.7301 7.49662 18.4417 8.7269 18.4417 10.525C18.4417 12.3051 19.7301 13.5534 21.2254 13.5534C22.7207 13.5534 24.0091 12.3028 24.0091 10.525Z" fill="#EA4335"/>
              <path d="M36.8574 10.525C36.8574 13.4024 34.6344 15.5228 31.9063 15.5228C29.1782 15.5228 26.9553 13.4024 26.9553 10.525C26.9553 7.62956 29.1782 5.52726 31.9063 5.52726C34.6344 5.52726 36.8574 7.62731 36.8574 10.525ZM34.69 10.525C34.69 8.7269 33.4016 7.49662 31.9063 7.49662C30.411 7.49662 29.1226 8.7269 29.1226 10.525C29.1226 12.3051 30.411 13.5534 31.9063 13.5534C33.4016 13.5534 34.69 12.3028 34.69 10.525Z" fill="#FBBC05"/>
              <path d="M47.0932 5.8292V14.8017C47.0932 18.4926 44.9437 20 42.4025 20C40.0105 20 38.5708 18.3799 38.0278 17.055L39.9148 16.2596C40.2508 17.073 41.0741 18.0329 42.4003 18.0329C44.0269 18.0329 45.0349 17.0167 45.0349 15.1037V14.3849H44.9593C44.4742 14.991 43.5396 15.5205 42.3603 15.5205C39.8925 15.5205 37.6317 13.3438 37.6317 10.543C37.6317 7.72195 39.8925 5.52726 42.3603 5.52726C43.5374 5.52726 44.472 6.05678 44.9593 6.64488H45.0349V5.83146H47.0932V5.8292ZM45.1885 10.543C45.1885 8.78324 44.0291 7.49662 42.5538 7.49662C41.0585 7.49662 39.8057 8.78324 39.8057 10.543C39.8057 12.2848 41.0585 13.5534 42.5538 13.5534C44.0291 13.5534 45.1885 12.2848 45.1885 10.543Z" fill="#4285F4"/>
              <path d="M50.4866 0.570077V15.2163H48.3727V0.570077H50.4866Z" fill="#34A853"/>
              <path d="M58.7243 12.1699L60.4065 13.3055C59.8636 14.119 58.5552 15.5205 56.2944 15.5205C53.4907 15.5205 51.3968 13.3258 51.3968 10.5228C51.3968 7.5507 53.5085 5.52501 56.0518 5.52501C58.613 5.52501 59.8658 7.589 60.2753 8.70437L60.5 9.27219L53.9023 12.0392C54.4074 13.0419 55.1929 13.5534 56.2944 13.5534C57.3981 13.5534 58.1635 13.0036 58.7243 12.1699ZM53.5463 10.3718L57.9566 8.51735C57.7141 7.89319 56.9842 7.45831 56.1253 7.45831C55.0238 7.45831 53.4907 8.44299 53.5463 10.3718Z" fill="#EA4335"/>
              <path d="M8.27259 9.22488V7.10455H15.3287C15.3976 7.47409 15.4332 7.91122 15.4332 8.38441C15.4332 9.97521 15.0038 11.9423 13.6197 13.3438C12.2735 14.7634 10.5534 15.5205 8.27481 15.5205C4.0514 15.5205 0.5 12.037 0.5 7.76025C0.5 3.48355 4.0514 0 8.27481 0C10.6113 0 12.2757 0.928346 13.5263 2.13835L12.0487 3.63452C11.152 2.78278 9.93703 2.12032 8.27259 2.12032C5.18847 2.12032 2.77637 4.63722 2.77637 7.76025C2.77637 10.8833 5.18847 13.4002 8.27259 13.4002C10.273 13.4002 11.4123 12.5868 12.1422 11.8477C12.7341 11.2483 13.1235 10.3921 13.277 9.22262L8.27259 9.22488Z" fill="#4285F4"/>
            </svg>
          </header><!-- top -->
          <div class="widget-content">
            <div class="content-item">
              <p class="widget-reviews-count-average">5.0</p>
            </div><!-- content-item -->
            <div class="content-item">
              <div class="stars">
                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px"><path d="m233-120 65-281L80-590l288-25 112-265 112 265 288 25-218 189 65 281-247-149-247 149Z"/></svg>
                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px"><path d="m233-120 65-281L80-590l288-25 112-265 112 265 288 25-218 189 65 281-247-149-247 149Z"/></svg>
                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px"><path d="m233-120 65-281L80-590l288-25 112-265 112 265 288 25-218 189 65 281-247-149-247 149Z"/></svg>
                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px"><path d="m233-120 65-281L80-590l288-25 112-265 112 265 288 25-218 189 65 281-247-149-247 149Z"/></svg>
                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px"><path d="m233-120 65-281L80-590l288-25 112-265 112 265 288 25-218 189 65 281-247-149-247 149Z"/></svg>
              </div><!-- stars -->
              <p class="widget-reviews-count-total">50 Bewertungen</p>
            </div><!-- content-item -->
          </div><!-- widget-content -->
        </div><!-- widget-reviews -->

        

      </div><!-- footer_widget_right -->
    </div><!-- row -->
  </div><!-- .container -->
</footer><!-- site-footer -->