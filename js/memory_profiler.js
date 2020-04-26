/**
 * @file
 * The memory_profiler behavior.
 */

(function (Drupal, $) {
  'use strict';

  var triggered = false;

  Drupal.behaviors.memory_profiler = {
    attach: function (context, settings) {
      'use strict';

      if (!triggered) {
        $.ajax({
          url: Drupal.url('memory-profiler/ajax/performance-data'),
          type: 'GET',
          success: function (results) {
            if (results) {
              $('#memory-profiler').html(results);
              console.log(results);
            }
          }
        });

        triggered = true;
      }

    }
  };

})(Drupal, jQuery);
