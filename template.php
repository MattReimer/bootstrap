<?php

/**
 * @file
 * Provides preprocess logic and other utilities to Spinoza and child themes.
 */


/**
 * Implements template_preprocess_html();
 */
function spinoza_preprocess_html(&$variables, $hook) {
  // Get path to the parent theme:
  $path_to_spinoza = drupal_get_path('theme', 'spinoza');
  // Decide whether or not to add less.js to the theme:
  $less_js_setting = theme_get_setting('spinoza_use_less_js');
  switch ($less_js_setting) {
    case 'theme-less':
      drupal_add_js($path_to_spinoza . theme_get_setting('spinoza_less_js_theme_path'));
      break;
    case 'cdn-less':
      drupal_add_js(theme_get_setting('spinoza_less_js_cdn_url'));
      break;
    default:
  }
} // spinoza_preprocess_html()