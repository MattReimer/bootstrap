/**
 * @file
 * 
 */

(function($) {
  /**
   * Make Drupal's alert messages behave like Bootstrap's alerts.
   *
   * @see http://twitter.github.com/bootstrap/javascript.html#alerts
   * @see http://stackoverflow.com/questions/7643308/how-to-automatically-close-alerts-using-twitter-bootstrap
   */
  Drupal.behaviors.bootstrapAlertMessages = {
    attach: function(context) {
      if (Drupal.settings.bootstrap.alertMessage === true) {
        $('.block-message').each(function(i,e) {
          var $currentMessage = $(e);
          $currentMessage
            .find('.close')
              .click(function(e) {
                $currentMessage
                  .animate(
                    {opacity: 0},
                    1000,
                    function() {
                      $currentMessage.slideUp('slow');
                    }
                  );
                e.preventDefault();
              });
        });
      }
    }
  }; /* Drupal.behaviors.bootstrapAlertMessages */
})(jQuery);