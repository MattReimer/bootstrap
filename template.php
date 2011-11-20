<?php

/**
 * @file
 * Provides preprocess logic and other utilities to Bootstrap and child themes.
 */


// Include required functions:
require_once('includes.php');
require_once('lib/theme-includes/form.inc.php');
require_once('lib/theme-includes/webform.inc.php');


/**
 * Implements theme_breadcrumb().
 */
function bootstrap_breadcrumb($variables) {
  // Convenience variable:
  $breadcrumb = $variables['breadcrumb'];
  // If we have any breadcrumbs:
  if (!empty($breadcrumb)) {
    // Convert 'em to a string:
    $breadcrumbs = implode(' <span class="divider">/</span> ', $breadcrumb);
    // Build a heading--here at least, we're following the D7 convention of
    // accompanying menus with invisible headings to aid in text-only navigation:
    $heading = t('You are here');
    // Pattern for output:
    $output_pattern = '<h2 class="element-invisible">%s</h2><ul class="breadcrumb">%s</ul>';
    // Return the markup:
    return sprintf($output_pattern, $heading, $breadcrumbs);
  }
} // bootstrap_breadcrumb()


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
  // Retrieve and make available variables for use in column classes--if there
  // are any sidebars:
  $sidebar_regions = _bootstrap_get_sidebar_regions();
  // Count the results:
  $sidebar_count = count($sidebar_regions);
  // Special circumstances may apply if there are exactly two sidebars:
  $equal_columns = ($sidebar_count == 2 && theme_get_setting('bootstrap_one_third'));
  if ($sidebar_count > 0) {
    // Loop through them, and provide a variable for each sidebar's width. If
    // there are exactly two columns, we do something a bit different inside
    // the loop:
    foreach ($sidebar_regions as $key => $name) {
      $variables[sprintf(BOOTSTRAP_PAGE_TEMPLATE_VARIABLE_PATTERN, $key)] = !$equal_columns ? theme_get_setting(sprintf(BOOTSTRAP_THEME_SETTINGS_VARIABLE_PATTERN, $key)) : '-one-third';
    }
    // We also have to do the same for the content region, but that should be 
    // more straightforward as that region MUST exist:
    $variables[sprintf(BOOTSTRAP_PAGE_TEMPLATE_VARIABLE_PATTERN, 'content')] = !$equal_columns ? theme_get_setting(sprintf(BOOTSTRAP_THEME_SETTINGS_VARIABLE_PATTERN, 'content')) : '-one-third';
  }
  
  drupal_set_message('This is a status message', 'status');
  drupal_set_message('This is a warning message', 'warning');
  drupal_set_message('This is an error message', 'error');
} // bootstrap_preprocess_page()


/**
 * Implements theme_status_messages().
 *
 * @todo:
 *  -- clean up this mess of concatenation
 */
function bootstrap_status_messages(&$variables) {
  $display = $variables['display'];
  $output = '';

  $status_heading = array(
    'status' => t('Status message'),
    'error' => t('Error message'),
    'warning' => t('Warning message'),
  );
  foreach (drupal_get_messages($display) as $type => $messages) {
    $class = $type != 'status' ? $type : 'success';
    $output .= "<div class=\"alert-message block-message $class\">\n<a class=\"close\" href=\"#\">&#215;</a>";
    if (!empty($status_heading[$type])) {
      $output .= '<h2 class="element-invisible">' . $status_heading[$type] . "</h2>\n";
    }
    if (count($messages) > 1) {
      $output .= " <ul>\n";
      foreach ($messages as $message) {
        $output .= '  <li>' . $message . "</li>\n";
      }
      $output .= " </ul>\n";
    }
    else {
      $output .= $messages[0];
    }
    $output .= "</div>\n";
  }
  drupal_add_js(array('bootstrap' => array('alertMessage' => TRUE)), 'setting');
  drupal_add_js(drupal_get_path('theme', 'bootstrap') . '/' . 'Drupal.behaviors.bootstrapAlertMessages.min.js');
  return $output;
} // bootstrap_status_messages()