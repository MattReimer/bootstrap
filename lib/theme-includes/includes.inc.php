<?php

/**
 * @file
 * Provides constants and functions used in both theme-settings.php and
 * template.php.
 */


// Constants
define('BOOTSTRAP_THEME_SETTINGS_COLUMN_VARIABLE_PATTERN', 'bootstrap_%s_size');
define('BOOTSTRAP_THEME_SETTINGS_ROW_VARIABLE_PATTERN', 'bootstrap_%s_size');
define('BOOTSTRAP_PAGE_TEMPLATE_VARIABLE_PATTERN', '%s_size');
define('BOOTSTRAP_GRID_COLUMNS', 16);


/**
 * Returns an array of regions available in the theme whose keys begin with the
 * string in $region_type--usually 'sidebar_' or 'row_' (or an empty array).
 *
 * @param array $region_types
 *    The types of regions--currently the theme settings and template.php only
 *    anticipate values of 'sidebar_' or 'row_'.
 * @param string $theme_override
 *    The theme whose row or sidebar regions are to be found (if not provided,
 *    the default theme will be used).
 * @return array $theme_regions
 *    The array of theme regions, regardless of how many items it contains.
 */
function _bootstrap_get_multiple_regions($region_types = array('sidebar_'), $theme_override = NULL) {
  // Find out the current theme--or at least the theme the caller is interested
  // in:
  $current_theme = $theme_override ? $theme_override : variable_get('theme_default', $theme_override);
  // Retrieve information about the available regions in this theme:
  $regions = system_region_list($current_theme);
  // Go through the regions and find all those regions whose key begins with
  // 'sidebar_' etc; make a new array containing only those:
  $theme_regions = array();
  // Loop through the region types:
  foreach ($region_types as $region_type) {
    foreach ($regions as $key => $name) {
      if (strpos($key, $region_type) === 0) {
        $theme_regions[$region_type][$key] = $name;
      }
    }
  }
  // Return the result--whatever it is:
  return $theme_regions;
} // _bootstrap_get_multiple_regions()