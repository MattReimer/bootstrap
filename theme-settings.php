<?php

/**
 * @file
 * Provides advanced theme settings to the Spinoza theme.
 */


/**
 * Implements hook_form_system_theme_settings_alter().
 */
function bootstrap_form_system_theme_settings_alter(&$form, &$form_state) {
  // Retrieve information about the available regions in this theme:
  $regions = system_region_list('bootstrap');
  // Go through the regions and find all those regions whose key begins with
  // 'sidebar_'; make a new array containing only those:
  $sidebar_regions = array();
  foreach ($regions as $key => $name) {
    if (strpos($key, 'sidebar_') === 0) {
      $sidebar_regions[$key] = $name;
    }
  }
  $sidebar_count = count($sidebar_regions);
  kpr($sidebar_regions);
  
  // Build our part of the form:
  $form['bootstrap_layout_settings'] = array(
    '#collapsed' => FALSE,
    '#collapsible' => TRUE,
    '#title' => t('Bootstrap layout settings'),
    '#type' => 'fieldset',
  );
  // If no sidebar region is defined, we can just forgo display of this fieldset
  // altogether--if there're no sidebars, then the content region is obviously
  // full-width:
  if ($sidebar_count > 0) {
    // Set up the basic field set:
    $form['bootstrap_layout_settings']['bootstrap_column_sizes'] = array(
      '#collapsed' => TRUE,
      '#collapsible' => TRUE,
      '#title' => t('Bootstrap column sizes'),
      '#type' => 'fieldset',
    );
    // Set up the main content area--themes must have a region called 'content':
    $form['bootstrap_layout_settings']['bootstrap_column_sizes']['bootstrap_content_size'] = array(
      '#default_value' => theme_get_setting('bootstrap_content_size'),
      '#maxlength' => 2,
      '#size' => 5,
      '#title' => t('Content region width'),
      '#type' => 'textfield',
    );
    // Add sidebar settings items:
    foreach ($sidebar_regions as $key => $name) {
      $form['bootstrap_layout_settings']['bootstrap_column_sizes']['bootstrap_' . $key . '_size'] = array(
        '#default_value' => theme_get_setting('bootstrap_' . $key . '_size'),
        '#maxlength' => 2,
        '#size' => 5,
        '#title' => t('@name width', array('@name' => $name)),
        '#type' => 'textfield',        
      );
    }
  }
  else {
    // Set the width of the main column in a hidden field:
    $form['bootstrap_layout_settings']['bootstrap_content_size'] = array(
      '#default_value' => 16,
      '#maxlength' => 2,
      '#size' => 5,
      '#type' => 'hidden',
    );
  }
} // bootstrap_form_system_theme_settings_alter()