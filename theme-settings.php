<?php

/**
 * @file
 * Provides advanced theme settings to the Spinoza theme.
 */


/**
 * Implements hook_form_system_theme_settings_alter().
 */
function spinoza_form_system_theme_settings_alter(&$form, &$form_state) {
  // Less css fieldset
  $form['spinoza_less_js'] = array(
    '#collapsed' => FALSE,
    '#collapsible' => TRUE,
    '#description' => t('Contains settings related to the use of Less css in this theme'),
    '#title' => t('Less css settings'),
    '#type' => 'fieldset',
  );
  $form['spinoza_less_js']['spinoza_use_less_js'] = array(
    '#default_value' => theme_get_setting('spinoza_use_less_js'),
    '#description' => t('<p>Use javascript to process *.less files in theme.</p><p><strong>Warning</strong>: visitors with javascript disabled will <em>not</em> see the fully-styled theme. It is strongly recommended to process *.less files on the server with nodejs or to convert *.less files to *.css files on the command line before putting the site into production. See !usage at lesscss.org for documentation.</p>', array('!usage' => l('"Usage" section', 'http://lesscss.org/#-client-side-usage'))),
    '#options' => array(
      'no-less' => t('Do not use less.js'),
      'theme-less' => t('Use theme less.js'),
      'cdn-less' => t('Use less.js from CDN'),
    ),
    '#title' => t('Javascript processing for *.less files'),
    '#type' => 'radios',
  );
  $form['spinoza_less_js']['spinoza_less_js_cdn_url'] = array(
    '#default_value' => theme_get_setting('spinoza_less_js_cdn_url'),
    '#description' => t('Full URL to CDN location of less.js file.'),
    '#title' => t('less.js CDN URL'),
    '#type' => 'textfield',
  );
} // spinoza_form_system_theme_settings_alter()