<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package stewe
 */

get_header();

$page_id        = get_option( 'page_for_posts' );
$posts_per_page = get_option('posts_per_page', 12);
$paged          = get_query_var('paged') ? get_query_var('paged') : 1;
$stickys        = get_option('sticky_posts');

$magazin_args = array(
  'post_type'           => 'post',
  'post_status'         => 'publish',
  'orderby'             => 'publish_date',
  'order'               => 'DESC',
  'ignore_sticky_posts' => 0,
  'paged'               => $paged,
  'posts_per_page'      => $posts_per_page,
);

$fakt_args = array(
  'post_type'           => 'fakt',
  'posts_per_page'      => -1,
);

$categories = get_terms(array(
  'taxonomy' => 'category',
  'hide_empty' => true,
));

$magazin_posts        = new WP_Query( $magazin_args );
$fakt_posts           = new WP_Query( $fakt_args );



?>


<div class="container">
  <div class="row">
    <div class="col-xs-12">
      <?php      
      $args = array(
        'btn' => array(
          'show'  => true,
          'url'   => home_url('magazin'),
        ),
        'data_query'    => $magazin_alle_posts->query_vars,
        'count_posts'   => $magazin_alle_posts->found_posts,
        'items'         => $categories,
        'data_type'     => 'single', // single | multiple
      );
      get_template_part( 'template-parts/filter', 'tags', $args );
      ?>
    </div>
  </div>
</div>

<div class="container">
  <div class="wrapper-magazin margin-bottom-xl" id="filter-wrapper">
  
  <?php 
 
  if ($magazin_posts->have_posts() ) {
    while($magazin_posts->have_posts() ): $magazin_posts->the_post();
      
      $highlight_icons = array();
      $post_ID        = get_the_ID();
      $post_title     = get_the_title();
      $post_date      = get_the_date();
      $post_date_gmt  = get_the_modified_date();
      $post_type      = get_post_type();
      $post_url       = get_the_permalink($post_ID);      
      $post_tags      = wp_get_post_terms($post_ID, "category");
      $highlight_tags = wp_get_post_terms($post_ID, "highlight");
      
      $post_thumbnail = array(
        'alt'           => get_post_meta($post_ID, '_wp_attachment_image_alt', true),
        'size_mobile'   => get_the_post_thumbnail_url($post_ID , 'thumbnail'),
        'size_large'    => get_the_post_thumbnail_url($post_ID , 'gallery-squer'),
      );

      if($highlight_tags): 
        foreach($highlight_tags as $icon):
          $icon = get_field('icon', $icon->taxonomy . '_' . $icon->term_id);          
          array_push($highlight_icons, '<i class="huber-icons '.$icon.'"></i>');
        endforeach;
      endif;

      $args = array(
        'ID'              => $post_ID,
        'post_title'      => $post_title,
        'post_date'       => $post_date,
        'post_date_gmt'   => $post_date_gmt,
        'post_type'       => $post_type,
        'post_url'        => $post_url,
        'post_thumbnail'  => $post_thumbnail,
        'post_tags'       => $post_tags,
        'post_header'     => array(
          'first' => array(),
          'last'  => $highlight_icons,
        ),
      );

      if(in_array($post_ID, $stickys)){
        $args['post_header']['first'] = array('<svg xmlns="http://www.w3.org/2000/svg" width="34" height="35" viewBox="0 0 34 35" fill="none"><path d="M27.1469 16.0853C28.5187 17.2979 29.7951 17.3166 30.9763 16.1413C31.8135 15.31 32.636 14.464 33.4791 13.6385C34.1837 12.9487 34.166 12.3001 33.4732 11.6103C29.8502 8.00202 26.236 4.39077 22.6247 0.770668C21.9349 0.0778969 21.2863 0.0572612 20.5936 0.761824C19.491 1.88205 18.3708 2.99048 17.2594 4.10187C16.5667 4.79464 16.5961 5.46677 17.2948 6.14186C17.5631 6.40128 17.8048 6.69018 18.1792 7.09994C16.1952 9.03381 14.3056 10.891 12.3894 12.7217C12.1742 12.9251 11.7644 13.1285 11.5138 13.0637C8.04705 12.1586 5.53833 13.6709 3.30672 16.1178C2.44297 17.067 2.4695 17.7509 3.36568 18.6029C5.14625 20.295 6.87671 22.0343 8.73392 23.8591C8.38606 24.2306 8.1915 24.4487 7.98219 24.6551C5.444 27.1933 2.87632 29.699 0.400033 32.2962C0.0521733 32.6617 -0.1306 33.6375 0.108185 34.0148C0.632922 34.8403 1.36696 34.4423 1.94771 33.8527C2.56973 33.2218 3.2006 32.6028 3.81967 31.9719C5.93336 29.811 8.0441 27.6472 10.2462 25.392C12.2125 27.3819 13.9282 29.2097 15.7678 30.9047C16.1746 31.2791 17.286 31.512 17.6191 31.2467C20.2369 29.1566 22.0499 26.6361 21.2451 22.9954C21.1743 22.6681 21.2097 22.167 21.4102 21.9547C22.2621 21.0585 23.5474 19.7496 24.4112 18.8653L23.005 17.2734C22.0734 18.1813 20.7351 19.4873 19.8006 20.3481C18.8307 21.2443 18.474 22.0638 18.9958 23.414C19.7298 25.3213 18.9486 27.0518 17.0472 28.682C13.2325 24.8673 9.42669 21.0585 5.50885 17.1407C7.03884 15.2835 8.95797 14.4669 11.5286 15.369C12.0386 15.5488 12.9642 15.2068 13.4064 14.7941C15.4523 12.8838 17.395 10.8645 19.3731 8.88346C20.5779 7.6748 20.6162 6.39341 19.4881 5.03932C20.1956 4.40845 20.912 3.77169 21.5693 3.18505C24.703 6.31873 27.8809 9.49958 31.0087 12.6303C30.4457 13.2317 29.7883 13.9304 28.9216 14.859C27.8102 13.6651 26.687 12.4417 25.5461 11.233C25.0008 10.6552 24.367 10.2041 23.6653 10.95C22.9814 11.6752 23.4295 12.309 24.0103 12.8426" fill="white"/></svg>');
      }

      get_template_part( 'template-parts/content', 'post', $args );

    endwhile;
    
  }  
  wp_reset_postdata();
  ?>  

    <?php 
    // Pagination
    if($magazin_posts->max_num_pages > 1):	

      if($magazin_posts->query_vars["paged"] == 0) {
        $current_page = 1;
      } else {
        $current_page = $magazin_posts->query_vars["paged"];
      }
      
    ?>
    <div class="pagination" data-query="<?php echo htmlspecialchars(json_encode($magazin_posts->query_vars)); ?>" data-maxpages="<?php echo htmlspecialchars(json_encode($magazin_posts->max_num_pages)); ?>" data-current="<?php echo $current_page; ?>" data-layout="content-post">
      <?php 
      $args = array(
        'total'       => $magazin_posts->max_num_pages,
        'next_text '	=> __('mehr laden', 'huber-parking')
      );
      $pagenav = paginate_links($args); 
      echo $pagenav;
      ?>
    </div>

    <?php endif; ?>

  </div><!-- wrapper-magazin -->
  
  
  
</div><!-- container -->


<?php

get_footer();