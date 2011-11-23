<?php

/**
 * @file
 * Provides theme_* functions for forms and form elements.
 */


/**
 * Implements theme_form_element().
 *
 * Specifically, this function attempts to tweak theme_form_element() to bring
 * its html minimally into line with Bootstrap's expectations.
 *
 * This implementation makes the following alterations:
 *
 *  1.  Add an additional div (div.input) that wraps form element and
 *      description in the 'before' and 'invisible' cases (around line
 *      67), and immediately before the element in the remaining cases (these
 *      may require additional styling);
 *
 * The general approach is to modify this function as minimally as possible so
 * as not to interfere with Webform any more than is necessary. Most of the
 * Bootstrap-ization is accomplished in the main lib/less/*.less files.
 *
 * Sub-theme implementations should be sure to modify theme_form_element() AND
 * theme_webform_element().
 *
 * @see bootstrap_webform_element()
 * @see theme_form_element()
 * @see theme_webform_element()
 *
 * @todo
 *    -- check div.input in 'after', 'none', 'attribute' cases.
 */
function bootstrap_form_element($variables) {
  $element = &$variables['element'];
  // This is also used in the installer, pre-database setup.
  $t = get_t();

  // This function is invoked as theme wrapper, but the rendered form element
  // may not necessarily have been processed by form_builder().
  $element += array(
    '#title_display' => 'before',
  );

  // Add element #id for #type 'item'.
  if (isset($element['#markup']) && !empty($element['#id'])) {
    $attributes['id'] = $element['#id'];
  }
  // Add element's #type and #name as class to aid with JS/CSS selectors.
  $attributes['class'] = array('form-item');
  if (!empty($element['#type'])) {
    $attributes['class'][] = 'form-type-' . strtr($element['#type'], '_', '-');
  }
  if (!empty($element['#name'])) {
    $attributes['class'][] = 'form-item-' . strtr($element['#name'], array(' ' => '-', '_' => '-', '[' => '-', ']' => ''));
  }
  // Add a class for disabled elements to facilitate cross-browser styling.
  if (!empty($element['#attributes']['disabled'])) {
    $attributes['class'][] = 'form-disabled';
  }
  $output = '<div' . drupal_attributes($attributes) . '>' . "\n";

  // If #title is not set, we don't display any label or required marker.
  if (!isset($element['#title'])) {
    $element['#title_display'] = 'none';
  }
  $prefix = isset($element['#field_prefix']) ? '<span class="field-prefix">' . $element['#field_prefix'] . '</span> ' : '';
  $suffix = isset($element['#field_suffix']) ? ' <span class="field-suffix">' . $element['#field_suffix'] . '</span>' : '';

  // Set up the children a bit differently than the default:
  $children .= "<div class=\"input\">\n";
  $children .= $prefix . $element['#children'] . $suffix . "\n";
  $children .= !empty($element['#description']) ? "<div class=\"description\">" . $element['#description'] . "</div>\n" : '';
  $children .= "</div>\n";

  switch ($element['#title_display']) {
    case 'before':
    case 'invisible':
      $output .= ' ' . theme('form_element_label', $variables);
      $output .= $children;
      //$output .= ' ' . $prefix . $element['#children'] . $suffix . "\n";
      break;

    case 'after':
      //$output .= ' ' . $prefix . $element['#children'] . $suffix;
      $output .= $children;
      $output .= ' ' . theme('form_element_label', $variables) . "\n";
      break;

    case 'none':
    case 'attribute':
      // Output no label and no required marker, only the children.
      //$output .= ' ' . $prefix . $element['#children'] . $suffix . "\n";
      $output .= $children;
      break;
  }

  $output .= "</div>\n";

  return $output;
} // bootstrap_form_element()