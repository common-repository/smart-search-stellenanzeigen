<?php

namespace Stellenanzeigen\Controllers;

use Stellenanzeigen\Helpers\StellenanzeigenApi;
use Stellenanzeigen\Helpers\StellenanzeigenFunctions;
use Stellenanzeigen\View\Render;

if (!defined('ABSPATH')) exit;

/**
 * The ApiController
 * It is responsible for everything running on admin side
 */
class ApiController {
  /**
   * Hold the class instance.
   */
  private static $instance = null;

  /**
   * The loader that's responsible for maintaining and registering all hooks that power
   * the plugin.
   */
  private $loader;

  /**
   * API contactd encapsulated
   */
  public $api;

  /**
   * Id of menu
   */
  public $menu_id;


  /**
   * Initialize the class and set its properties.
   */
  public function __construct($loader) {
    $this->loader = $loader;
    $this->api = new StellenanzeigenApi();
    $this->addBackendActionHooks();
  }


  /**
   * The object is created from within the class itself
   * only if the class has no instance.
   */
  public static function getInstance($loader) {
    if (null === self::$instance) {
      self::$instance = new ApiController($loader);
    }

    return self::$instance;
  }


  /**
   * Add all Hooks for the Backend
   */
  private function addBackendActionHooks() {
    // Add ajax action
    $this->loader->addAction('wp_ajax_jobs_ajaxFilter', $this, 'jobs_ajaxFilter__callback');
    $this->loader->addAction('wp_ajax_nopriv_jobs_ajaxFilter', $this, 'jobs_ajaxFilter__callback');
    $this->loader->addAction('wp_ajax_jobs_ajaxFilter_city', $this, 'jobs_ajaxFilter_city__callback');
    $this->loader->addAction('wp_ajax_nopriv_jobs_ajaxFilter_city', $this, 'jobs_ajaxFilter_city__callback');
  }


  /**
   * AJAX action - jobs list filter handling
   */
  public function jobs_ajaxFilter__callback() {
    if (isset($_POST['nonce']) && wp_verify_nonce($_POST['nonce'], 'jobs_ajaxFilter')) {
      $search = trim(sanitize_text_field($_POST['search']));
      $location = trim(sanitize_text_field($_POST['location']));
      $radius = trim(sanitize_text_field($_POST['radius']));
      $city = isset($_POST['city']) ? trim(sanitize_text_field($_POST['city'])) : 'all';
      $zip = trim(sanitize_text_field($_POST['zip']));
      $filterData = $search . ';' . $location . ';' . $radius . ';' . $city . ';' . $zip;
      $functions = new StellenanzeigenFunctions();
      $jobs = $this->api->getJobs();
      $filter = array(
        $functions->filter_types['ajaxFilter'] => $filterData
      );
      $filtered_jobs = $functions->filter_jobs($jobs, $filter);

      print Render::view('components/job-list', array('jobs' => $filtered_jobs));
    }

    die();
  }

  /**
   * AJAX action - jobs cities
   */
  public function jobs_ajaxFilter_city__callback() {
    if (isset($_POST['nonce']) && wp_verify_nonce($_POST['nonce'], 'jobs_ajaxFilter')) {
      $location = trim(sanitize_text_field($_POST['location']));
      $stellenanzeigen_jobs_city = get_option('stellenanzeigen_jobs_city');
      print Render::view('components/city-filter', array('cities' => $stellenanzeigen_jobs_city[$location]));
    }

    die();
  }
}
