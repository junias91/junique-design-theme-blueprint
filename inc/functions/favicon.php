<?php

if( ! function_exists('favicon') ):
  function favicon(){


    $link_to_favicon = get_stylesheet_directory_uri() . '/assets/favicon';
$fav = <<<EOT

<link rel="apple-touch-icon" sizes="180x180" href="$link_to_favicon/apple-touch-icon.png">
<link rel="icon" type="image/png" sizes="32x32" href="$link_to_favicon/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="$link_to_favicon/favicon-16x16.png">
<link rel="manifest" href="$link_to_favicon/site.webmanifest">
<link rel="mask-icon" href="$link_to_favicon/safari-pinned-tab.svg" color="#000000">
<meta name="apple-mobile-web-app-title" content="JUNIQUE Design">
<meta name="application-name" content="JUNIQUE Design">
<meta name="msapplication-TileColor" content="#000000">
<meta name="theme-color" content="#ffffff">

<link rel="icon" type="image/svg+xml" href="$link_to_favicon/favicon.svg">
<link rel="icon" href="$link_to_favicon/favicon-light.png" media="(prefers-color-scheme: light)">
<link rel="icon" href="$link_to_favicon/favicon-dark.png" media="(prefers-color-scheme: dark)">
EOT;

    echo $fav;

  }
endif;
add_action( 'wp_head', 'favicon', 10, 2 );