<?php

namespace Stellenanzeigen\Controllers;

use Stellenanzeigen\Helpers\StellenanzeigenFunctions;
use Stellenanzeigen\Helpers\StellenanzeigenApi;
use Stellenanzeigen\View\StellenanzeigenShortcodeView;

if (!defined('ABSPATH')) exit;

/**
 * The Frontend Controller.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 */
class FrontendController {
  // Hold the class instance.
  private static $instance = null;
  private $loader;

  /**
   * API contactd encapsulated
   */
  public $api;

  /**
   * Shortcode
   */
  public $shortcode = 'job_list';


  /**
   * Initialize the class and set its properties.
   */
  public function __construct($loader) {
    $this->loader = $loader;

    $this->api = new StellenanzeigenApi();

    $this->addActionHooks();
  }


  // The object is created from within the class itself
  // only if the class has no instance.
  public static function getInstance($loader) {
    if (null === self::$instance) {
      self::$instance = new FrontendController($loader);
    }

    return self::$instance;
  }


  /**
   * Adds all the actions needed tu run this Plugin
   */
  private function addActionHooks() {
    $this->loader->addAction('wp_enqueue_scripts', $this, 'front_enqueues');
    $this->loader->addAction('init', $this, 'create_shortcodes');
  }

  /**
   * Enques styled and scripts
   */
  public function front_enqueues() {
    wp_enqueue_script(
      'stellenanzeigen_frontend_script',
      STELLENANZEIGENE_URL . '/assets/script.js',
      array('wp-api-request', 'jquery')
    );
    wp_localize_script(
      'stellenanzeigen_frontend_script',
      'js_variables',
      array(
        'ajaxurl' => admin_url('admin-ajax.php'),
        'pluginUrl' => STELLENANZEIGENE_URL,
      )
    );
    wp_enqueue_style('stellenanzeigen_frontend_styles', STELLENANZEIGENE_URL . '/assets/style.css');
  }

  /**
   * Will get the Jobs and filters them
   */
  public function getJobs($filter) {
    $functions = new StellenanzeigenFunctions();

    $jobs = $this->api->getJobs(array(
      'company' => $filter['company'] ?? null
    ));

    $filtered_jobs = $functions->filter_jobs($jobs, $filter);

    if (is_array($filtered_jobs)) {
      usort(
        $filtered_jobs,
        function ($a, $b) {
          $date1 = StellenanzeigenFunctions::getDate($a);
          $date2 = StellenanzeigenFunctions::getDate($b);
          return strtotime($date1) > strtotime($date2) ? -1 : 1;
        }
      );
    }
    return $filtered_jobs;
  }

  /**
   * Will create all the shortcodes needed
   */
  public function create_shortcodes() {
    add_shortcode($this->shortcode, array($this, 'stellenanzeigen_shortcode_ui'));
  }

  /**
   * Returns the code for tracking shipments
   */
  public function stellenanzeigen_shortcode_ui($atts) {
    $attributes = shortcode_atts(array(
      'company' => null,
      'jobs_ids' => null,
      'type' => null,
      'hide_type' => null,
      'hide_initiative' => null,
      'industry' => null,
      'with_filter' => false,
      'hover_color' => null,
      'orderBy' => 'jobTitle',
      'order' => 'desc'
    ), $atts);
    $jobs = $this->getJobs($attributes);
    // write_dump($jobs);
    // // Sort the jobs by sortby and sort option in $attributes
    // // Keep in mind that we need to be able to sort by data and by string
    if (is_array($jobs) && isset($attributes['orderBy']) && isset($attributes['order'])) {
      usort(
        $jobs,
        function ($a, $b) use ($attributes) {
          $date1 = StellenanzeigenFunctions::getDate($a);
          $date2 = StellenanzeigenFunctions::getDate($b);
          $sortOrder = isset($attributes['order']) && strtolower($attributes['order']) === 'desc' ? -1 : 1;

          if ($attributes['orderBy'] === 'date') {
            return (strtotime($date1) > strtotime($date2) ? -1 : 1) * $sortOrder;
          } else {
            return ($a->{$attributes['orderBy']} > $b->{$attributes['orderBy']} ? -1 : 1) * $sortOrder;
          }
        }
      );
    }
    return (new StellenanzeigenShortcodeView())->render($jobs, $attributes);
  }
}
