<?php

/**
 * @file
 * Provides constants and functions used in both theme-settings.php and
 * template.php.
 */
 

// Constants
define('BOOTSTRAP_THEME_SETTINGS_VARIABLE_PATTERN', 'bootstrap_%s_size');
define('BOOTSTRAP_PAGE_TEMPLATE_VARIABLE_PATTERN', '%s_size');
define('BOOTSTRAP_GRID_COLUMNS', 16);


/**
 * Returns an array of regions available in the theme whose keys begin with the
 * string 'sidebar_' (or an empty array).
 *
 * @param string $theme_override
 *    The theme whose sidebar_ regions are to be found (if not provided, the
 *    default theme will be used.
 * @return array $sidebar_regions
 *    The array of sidebar regions, regardless of how many items it contains.
 */
function _bootstrap_get_sidebar_regions($theme_override = NULL) {
  // Find out the current theme--or at least the theme the caller is interested
  // in:
  $current_theme = $theme_override ? $theme_override : variable_get('theme_default', $theme_override);  
  // Retrieve information about the available regions in this theme:
  $regions = system_region_list($current_theme);
  // Go through the regions and find all those regions whose key begins with
  // 'sidebar_'; make a new array containing only those:
  $sidebar_regions = array();
  foreach ($regions as $key => $name) {
    if (strpos($key, 'sidebar_') === 0) {
      $sidebar_regions[$key] = $name;
    }
  }
  // Return the result--whatever it is:
  return $sidebar_regions;
} // _bootstrap_get_sidebar_regions()