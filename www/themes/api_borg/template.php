<?php
/**
 * @file
 * Theme function overrides.
 */

/*******************************************************************************
 * Alter functions: modify renderable structures before used.
 ******************************************************************************/

/**
 * Implements hook_form_FORM_ID_alter().
 */
function api_borg_form_search_block_form_alter(&$form, $form_state) {
  // Add an autocomplete. See api-theme.js.
  $form['search_block_form']['#attributes']['data-typeahead'] = url('api/search/autocomplete/1');
  $form['search_block_form']['#attributes']['data-typeahead-selected'] = url('api/backdrop/1/search');

  $form['search_block_form']['#attributes']['placeholder'] = t('Search API and Documentation');
  $form['search_block_form']['#type'] = 'search';
}

/*******************************************************************************
 * Preprocess functions: prepare variables for templates.
 ******************************************************************************/

/**
 * Prepares variables for page templates.
 * @see page.tpl.php
 */
function api_borg_preprocess_page(&$variables) {
  backdrop_add_js('core/misc/tableheader.js');
  if (arg(0) == 'node' && arg(1) == '41642' && !arg(2)) {
    $path = backdrop_get_path('theme', 'api_borg');
    backdrop_add_css($path . '/css/page-form-api.css');
  }
}

/**
 * Prepares variables for layout templates.
 * @see layout.tpl.php
 */
function api_borg_preprocess_layout(&$variables) {
  if ($variables['content']['header']) {
    $variables['content']['header'] = '<div class="l-header-inner">' . $variables['content']['header'] . '</div>';
  }
}

/**
 * Prepares variables for search result templates.
 * @see search-results.tpl.php
 */
function api_borg_preprocess_search_results(&$variables) {
  foreach ($variables['search_results'] as $key => $result) {
    if (isset($result['result']['type'])) {
      $variables['search_results'][$key]['info'] = $result['result']['type'];
    }
  }
}

/**
 * Prepares variables for unformatted views templates.
 * @see views-view-unformatted.tpl.php
 */
function api_borg_preprocess_views_view_unformatted(&$variables) {
  if ($variables['view']->name == 'form_api') {
    // Re-word the title (content type).
    if (!empty($variables['title'])) {
      if ($variables['title'] == 'fapi_element') {
        $variables['title'] = t('Elements');
      }
      elseif ($variables['title'] == 'fapi_property') {
        $variables['title'] = t('Properties');
      }
    }
  }
}

/*******************************************************************************
 * Theme functions: override the output of theme functions.
 ******************************************************************************/

/**
 * Overrides theme_views_view_field().
 */
function api_borg_views_view_field($variables) {
  $view = $variables['view'];
  $field = $variables['field'];
  $row = $variables['row'];

  if ($variables['view']->name == 'form_api') {
    // Add a wrapper H3 tag with an ID, and add a '#' to property names.
    if ($field->field == 'title') {
      if ($row->node_type == 'fapi_property') {
        $output = '#' . $variables['output'];
      }
      else {
        $output = $variables['output'];
      }

      $variables['output'] = '<h3 id="' . $variables['output'] . '">' . $output . '</h3>';
    }
    elseif ($field->field == 'field_properties') {
      dpm($variables['output']);
      dpm($field);
    }
  }

  return $variables['output'];
}

/**
 * Overrides theme_field().
 */
// function api_borg_field($variables) {
//   dpm($variables);
//   $output = '';
//
//   // Render the label, if it's not hidden.
//   if (!$variables['label_hidden']) {
//     $output .= '<div class="field-label">' . $variables['label'] . ':&nbsp;</div>';
//   }
//
//   // Render the items.
//   $content_attributes = (isset($variables['content_attributes'])) ? backdrop_attributes($variables['content_attributes']) : '';
//   $output .= '<div class="field-items"' . $content_attributes . '>';
//   foreach ($variables['items'] as $delta => $item) {
//     $classes = 'field-item ' . ($delta % 2 ? 'odd' : 'even');
//     $item_attributes = (isset($variables['item_attributes'][$delta])) ? backdrop_attributes($variables['item_attributes'][$delta]) : '';
//     $output .= '<div class="' . $classes . '"' . $item_attributes . '>' . backdrop_render($item) . '</div>';
//   }
//   $output .= '</div>';
//
//   // Render the top-level DIV.
//   dpm($output = '<div class="' . implode(' ', $variables['classes']) . '"' . backdrop_attributes($variables['attributes']) . '>' . $output . '</div>');
//
//   return $output;
// }
