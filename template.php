<?php

/**
 * @file
 * Provides preprocess logic and other utilities to Spinoza and child themes.
 */


/**
 * 
 */
function spinoza_html_head_alter(&$head_elements) {
  //kpr($head_elements);
} // spinoza_html_head_alter()


/**
 * Implements template_preprocess_html();
 */
function spinoza_preprocess_html(&$variables, $hook) {
  // Get path to the parent theme--we need it for all we're going to do:
  $path_to_spinoza = drupal_get_path('theme', 'spinoza');
  /*
  // Add the less file with a link element:
  $element = array(
    '#tag' => 'link',
    '#attributes' => array(
      'href' => $path_to_spinoza . '/style.less', 
      'rel' => 'stylesheet',
      'type' => 'text/css',
    ),
  );
  drupal_add_html_head($element, 'spinoza_style_less');
  */
  
  //drupal_add_css($path_to_spinoza . '/style.less', array('group' => CSS_THEME));

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