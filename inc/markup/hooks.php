<?php

/**
 * Add action hooks
 * 
 */
$hooks = [
  'wp_body_open',
  'wp_body_close',
  'header_top',
  'header_middel',
  'header_bottom',
  'the_header',
  'the_logo',
  'site_header_asside'
];
foreach ($hooks as $hook_name) {
  if (!function_exists($hook_name)) {
      // Erstelle eine anonyme Funktion, die an den Hook gebunden wird
      $GLOBALS[$hook_name] = function() use ($hook_name) {
          do_action($hook_name);
      };

      // Erstelle die Funktion im globalen Namensraum
      eval("function $hook_name() { call_user_func(\$GLOBALS['$hook_name']); }");
  }
}