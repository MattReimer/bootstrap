<?php

/**
 * @file
 * Provides advanced theme settings to the Spinoza theme.
 */


// Include required functions:
require_once('includes.php');


/**
 * Implements hook_form_system_theme_settings_alter().
 */
function bootstrap_form_system_theme_settings_alter(&$form, &$form_state) {
  // Retrieve information about the available sidebar regions in this theme:
  $sidebar_regions = _bootstrap_get_sidebar_regions();
  // Count 'em:
  $sidebar_count = count($sidebar_regions);
  
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
    // If there are exactly two sidebars, then along with the content region,
    // we'll have three columns. This means we can take advantage of bootstrap's
    // 'one-third' class:
    if ($sidebar_count == 2) {
      $form['bootstrap_layout_settings']['bootstrap_column_sizes']['bootstrap_one_third'] = array(
        '#default_value' => theme_get_setting('bootstrap_one_third'),
        '#description' => t('If checked, settings below will be ignored and each column will be set to 1/3 the total width.'),
        '#title' => t('Make columns equal width'),
        '#type' => 'checkbox',
      );
    }
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
      $variable_name = sprintf(BOOTSTRAP_THEME_SETTINGS_VARIABLE_PATTERN, $key);
      $form['bootstrap_layout_settings']['bootstrap_column_sizes'][$variable_name] = array(
        '#default_value' => theme_get_setting($variable_name),
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