/**
 * @file
 * 
 */

(function($) {
  Drupal.behaviors.bootstrapGlobal = {
    attach: function(context) {
      $('.messages')
        .alert()
        .append($('<a class="close" href="#">×</a>'))
        .addClass('fade in')
        .attr('data-alert', 'alert')
        .find('.close').click(function() {
          alert($(this).parents('.messages').attr('class')); //.alert('close');
        });
    }
  };
})(jQuery);