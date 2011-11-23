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
 * Implements template_preprocess_block().
 */
function bootstrap_preprocess_block(&$variables) {
  // What region are we in:
  $current_region = $variables['block']->region;
  // Decide what to do:
  switch ($current_region) {
    case 'row_post_content':
      // Retrieve and make available variables for use in column classes--if there
      // are any sidebars:
      $row_region_details = _bootstrap_get_multiple_regions(array('row_'));
      $row_regions = $row_region_details['row_'];
      // Count the results:
      $row_count = count($row_regions);
      // ROWS
      //
      // We're not going to do anything at all if the row count is zero:
      if ($row_count > 0) {
        // But if there's at least one, we'll loop through:
        foreach ($row_regions as $key => $name) {
          $variable_name = sprintf(BOOTSTRAP_PAGE_TEMPLATE_VARIABLE_PATTERN, $key);
          $row_divisions_value = theme_get_setting(sprintf(BOOTSTRAP_THEME_SETTINGS_ROW_VARIABLE_PATTERN, $key));
          if ($row_divisions_value == 3) {
            $variables['classes_array'][] = 'span-one-third';
          }
          else {
            $variables['classes_array'][] = 'span' . $row_divisions_value;
          }
        }
      }
      break;
  }
} // bootstrap_preprocess_block()


/**
 * Implements template_preprocess_page().
 *
 * @todo
 *    -- review for quality and comment code from approximately 54-79
 */
function bootstrap_preprocess_page(&$variables, $hook) {
  // Retrieve and make available variables for use in column classes--if there
  // are any sidebars:
  $sidebar_region_details = _bootstrap_get_multiple_regions(array('sidebar_'));
  $sidebar_regions = $sidebar_region_details['sidebar_'];
  // Count the results:
  $sidebar_count = count($sidebar_regions);
  // SIDEBARS
  //
  // Special circumstances may apply if there are exactly two sidebars:
  $equal_columns = ($sidebar_count == 2 && theme_get_setting('bootstrap_one_third'));
  if ($sidebar_count > 0) {
    // Loop through them, and provide a variable for each sidebar's width. If
    // there are exactly two columns, we do something a bit different inside
    // the loop:
    foreach ($sidebar_regions as $key => $name) {
      $variable_name = sprintf(BOOTSTRAP_PAGE_TEMPLATE_VARIABLE_PATTERN, $key);
      $column_width_setting = theme_get_setting(sprintf(BOOTSTRAP_THEME_SETTINGS_COLUMN_VARIABLE_PATTERN, $key));
      // If our current column width value, whatever column this is, is not zero:
      if ($column_width_setting != 0) {
        $variables[$variable_name] = !$equal_columns ? $column_width_setting : '-one-third';
        if (is_numeric($variables[$variable_name])) {
          $filled_columns += (int) $column_width_setting;
        }
      }
      // But if it IS zero, we have to check if the variable exists and unset it--
      // the sidebar could contain content. Moreover, we MUST also keep track of
      // how many columns we expected to fill with the now-missing element(s):
      elseif (isset($variables['page'][$key])) {
        unset($variables['page'][$key]);
      }
    }
    // We also have to do the same for the content region, but that should be
    // more straightforward as that region MUST exist:
    $remaining_space = BOOTSTRAP_GRID_COLUMNS - $filled_columns;
    $content_width_setting = !$equal_columns ?  theme_get_setting(sprintf(BOOTSTRAP_THEME_SETTINGS_COLUMN_VARIABLE_PATTERN, 'content')) : '-one-third';
    $content_width = is_numeric($content_width_setting) && $remaining_space > $content_width_setting ? $remaining_space : $content_width_setting;
    $variables[sprintf(BOOTSTRAP_PAGE_TEMPLATE_VARIABLE_PATTERN, 'content')] = $content_width;
  }
} // bootstrap_preprocess_page()


/**
 * Implements template_preprocess_region().
 */
function bootstrap_preprocess_region(&$variables) {
  if (strstr($variables['region'], 'row_') !== FALSE) {
    $variables['classes_array'][] = 'row';
  }
} // bootstrap_preprocess_region()


/**
 * Implements theme_status_messages().
 *
 * @todo:
 *    -- clean up this mess of concatenation...hard to believe the core contains
 *       this kind of thing.
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
  drupal_add_js(drupal_get_path('theme', 'bootstrap') . '/lib/js/' . 'Drupal.behaviors.bootstrapAlertMessages.min.js');
  return $output;
} // bootstrap_status_messages()