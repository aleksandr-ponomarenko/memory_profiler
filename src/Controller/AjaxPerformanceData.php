<?php

namespace Drupal\memory_profiler\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class AjaxPerformanceData.
 */
class AjaxPerformanceData  extends ControllerBase {
  /**
   * Ajax callback for main performance data.
   */
  public function get() {
    $uid = \Drupal::currentUser()->id();
    $tempstore = \Drupal::service('tempstore.private')->get('memory_profiler');
    $storage = $tempstore->get('storage');
    $tempstore->set('storage', NULL);

    $message = implode(' | ', is_array($storage ?? []) ? $storage : []);

    $markup = [
      '#type' => 'markup',
      '#markup' => $message,
    ];

    // Return response.
    return new Response(render($markup));
  }

}
