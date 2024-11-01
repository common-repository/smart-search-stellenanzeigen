<?php

namespace Stellenanzeigen\View;

use Stellenanzeigen\View\Render;

if (!defined('ABSPATH')) exit;


/**
 * Shortcode view
 */
class StellenanzeigenShortcodeView {
  public function render($jobs, $atts) {
    if (isset($atts) && is_array($atts)) {
      if (!key_exists('with_filter', $atts) || $atts['with_filter'] == false) {
        if ($jobs) {
          return Render::view('components/job-list', array('jobs' => $jobs, 'hover_color' => $atts['hover_color'] ?? '#24A5EF'));
        }
      } else {
        $jobsView = Render::view('components/job-filters', array('jobs', $jobs));

        if ($jobs) {
          $jobsView .=  Render::view('components/job-list', array('jobs' => $jobs, 'hover_color' => $atts['hover_color'] ?? '#24A5EF'));
          return $jobsView;
        }
      }
    }
  }
}
