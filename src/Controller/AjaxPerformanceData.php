<?php

namespace Drupal\memory_profiler\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class AjaxPerformanceData.
 */
class AjaxPerformanceData extends ControllerBase {

  /**
   * Ajax callback for main performance data.
   */
  public function get() {
    $tempstore = \Drupal::service('tempstore.private')->get('memory_profiler');
    $storage = $tempstore->get('storage');
    $tempstore->set('storage', NULL);
    $storage = is_array($storage ?? []) ? $storage : [];

    $message = '';
    if (count($storage)) {
      $message = '<div id="memory-profiler-short">' . '[' . count($storage) . '] ' . ($storage[count($storage) - 1]['short'] ?? '') . '</div>';
    }

    $details = '';
    foreach ($storage as $value) {
      $details .= "<div>{$value['long']}</div>";
    }

    $markup = [
      '#type' => 'markup',
      '#markup' => $message . "<div id=\"memory-profiler-long\">$details</div>",
    ];

    // Return response.
    return new Response(render($markup));
  }

}
