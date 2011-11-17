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
  Drupal.behaviors.bootstrapAlerts = {
    attach: function(context) {
      // We're looking for messages:
      var $messages = $('.messages');
      if ($messages.size() > 0) {
        $messages
          .each(function(i,e) {
            var $currentMessage = $(e)
                // We can't theme a link into the messages, so add it here:
                .append($('<a class="close" href="#">&#215;</a>')
                  // Add click handler:
                  .click(function(e){
                    // We also can't seem to use the Bootstrap 'alert' js to
                    // make them go away (which renders the tool pointless), so
                    // just handle it nicely here:
                    $currentMessage
                      .animate(
                        {opacity: 0},
                        1000,
                        function() {
                          $currentMessage.slideUp('slow');
                        }
                      );
                    e.preventDefault();
                  })
                );
          });
      }
    }
  }; /* Drupal.behaviors.bootstrapAlerts */
})(jQuery);
