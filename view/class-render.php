<?php

namespace Stellenanzeigen\View;

if (!defined('ABSPATH')) exit;

/**
 * This is used to render all sort of views.
 */
class Render {
  public static function view($view, $data) {
    extract($data);

    // path to file
    $file = STELLENANZEIGENE_PATH . 'view/' . $view . '.php';

    if (file_exists($file)) {
      ob_start();
      require($file);
      $result = ob_get_contents();
      ob_end_clean();
      return $result;
    } else {
      echo __('Something strange happened', 'smartsearch-job-ads');
    }
  }
}
