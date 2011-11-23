<?php

/**
 * @file
 * Provides theme overrides for webform forms.
 */


/**
 * Implements theme_webform_element().
 *
 * Specifically, this function attempts to tweak Webform's own implementation of
 * theme_form_element() to bring its html minimally into line with Bootstrap's
 * expectations.
 *
 * This implementation makes the following alteration to the Webform version:
 *
 *  1.  Add an additional div (div.input) that wraps form element and
 *      description in the 'inline', 'before' and 'invisible' cases (around line
 *      66), and immediately before the element in the remaining cases (these
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
function bootstrap_webform_element($variables) {
  // Ensure defaults.
  $variables['element'] += array(
    '#title_display' => 'before',
  );

  $element = $variables['element'];

  // All elements using this for display only are given the "display" type.
  if (isset($element['#format']) && $element['#format'] == 'html') {
    $type = 'display';
  }
  else {
    $type = (isset($element['#type']) && !in_array($element['#type'], array('markup', 'textfield'))) ? $element['#type'] : $element['#webform_component']['type'];
  }
  $parents = str_replace('_', '-', implode('--', array_slice($element['#parents'], 1)));

  $wrapper_classes = array(
   'form-item',
   'webform-component',
   'webform-component-' . $type,
  );
  if (isset($element['#title_display']) && $element['#title_display'] == 'inline') {
    $wrapper_classes[] = 'webform-container-inline';
  }

  $output = '<div class="' . implode(' ', $wrapper_classes) . '" id="webform-component-' . $parents . '">' . "\n";
  $required = !empty($element['#required']) ? '<span class="form-required" title="' . t('This field is required.') . '">*</span>' : '';

  // If #title is not set, we don't display any label or required marker.
  if (!isset($element['#title'])) {
    $element['#title_display'] = 'none';
  }
  $prefix = isset($element['#field_prefix']) ? '<span class="field-prefix">' . _webform_filter_xss($element['#field_prefix']) . '</span> ' : '';
  $suffix = isset($element['#field_suffix']) ? ' <span class="field-suffix">' . _webform_filter_xss($element['#field_suffix']) . '</span>' : '';

  // Set up the children a bit differently than the default:
  $wrapper = $element['#type'] == 'checkbox' ? FALSE : TRUE;
  $children .= $wrapper ? "<div class=\"input\">\n" : "";
  $children .= $prefix . $element['#children'] . $suffix . "\n";
  $children .= !empty($element['#description']) ? "<div class=\"description\">" . $element['#description'] . "</div>\n" : '';
  $children .= $wrapper ? "</div>\n" : "";

  switch ($element['#title_display']) {
    case 'inline':
    case 'before':
    case 'invisible':
      $output .= ' ' . theme('form_element_label', $variables);
      //$output .= ' ' . $prefix . $element['#children'] . $suffix . "\n";
      $output .= $children;
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
} // bootstrap_webform_element()