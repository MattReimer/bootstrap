<?php

/**
 * @file
 * Provides preprocess logic and other utilities to Bootstrap and child themes.
 */


/**
 * 
 */
function bootstrap_html_head_alter(&$head_elements) {
  
} // bootstrap_html_head_alter()


/**
 * Implements template_preprocess_html();
 */
function bootstrap_preprocess_html(&$variables, $hook) {
  
} // bootstrap_preprocess_html()


/**
 * Implements template_preprocess_page();
 */
function bootstrap_preprocess_page(&$variables, $hook) {
  drupal_set_message('This is a status message', 'status');
  drupal_set_message('This is a warning message', 'warning');
  drupal_set_message('This is an error message', 'error');
} // bootstrap_preprocess_page()