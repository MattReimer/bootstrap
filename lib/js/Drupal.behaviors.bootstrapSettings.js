(function($) {
  /**
   * Provides jQuery UI compoenents to Bootstrap theme settings page.
   *
   * @todo
   *    -- provide slider settings, width in single variable (except overrides)
   *    -- create, destroy (or hide) sliders on equal-columns checbox check
   *    -- enable/disable column input fields on equal-columns checkbox check
   *    -- minify and change reference
   *    -- think about having sliders mutually interact (may be too difficult
   *       given that we allow an open-ended number of sidebars)
   */
  Drupal.behaviors.bootstrapSettings = {
    attach: function(context) {
      var $thirdsCheckbox = $('#edit-bootstrap-one-third');      
      if (!$thirdsCheckbox.is(':checked')) {
        var fieldCss = {
              borderStyle: 'none',
              fontWeight: 'bold',
              textAlign: 'center',
              width: 200
            },
            $contentField = $('#edit-bootstrap-content-size')
              .css(fieldCss),
            $contentSlider = $('<div id="' + $contentField.attr('id') + '-slider"/>')
              .width(200)
              .insertBefore($contentField)
              .slider({
                max: 12,
                min: 4,
                range: 'min',
                slide: function(event, ui) {
                  $contentField.val(ui.value);
                },
                value: $contentField.val()
              }),
            $sidebarFields = $('#edit-bootstrap-column-sizes input:not(#edit-bootstrap-content-size, input[type=checkbox])')
              .each(function(i, e) {
                var $currentField = $(e)
                      .css(fieldCss),
                    $currentSlider = $('<div id="' + $currentField.attr('id') + '-slider"/>')
                      .width(200)
                      .insertBefore($currentField)
                      .slider({
                        max: 6,
                        min: 0,
                        range: 'min',
                        slide: function(event, ui) {
                          $currentField.val(ui.value);
                        },
                        value: $currentField.val()
                      });
              });
      }
    }
  }; /* Drupal.behaviors.bootstrapSettings */
})(jQuery);