<?php

namespace Stellenanzeigen\Controllers;

use Stellenanzeigen\Controllers\CronjobController;
use Stellenanzeigen\Controllers\DeactivationController;
use Stellenanzeigen\Controllers\LoaderController;
use Stellenanzeigen\Controllers\BackendController;
use Stellenanzeigen\Controllers\FrontendController;
use Stellenanzeigen\Controllers\ApiController;
use Stellenanzeigen\Controllers\I18nController;

if (!defined('ABSPATH')) exit;

/**
 * The CoreController
 * It is the main entry point of the Plugin
 */
class CoreController {
  /**
   * The loader that's responsible for maintaining and registering all hooks that power
   * the plugin.
   *
   * @since    1.0.0
   * @access   protected
   * @var      Loader    $loader    Maintains and registers all hooks for the plugin.
   */
  public $loader;

  /**
   * The single instance of this plugin.
   * @access private
   * @var Stellenanzeigen
   */
  private static $instance;

  /**
   * Constructor.
   */
  private function __construct() {
    $this->loader = new LoaderController();

    $this->set_locale();

    if (!is_admin() || wp_doing_ajax()) {
      FrontendController::getInstance($this->loader);
      ApiController::getInstance($this->loader);
    } else {
      BackendController::getInstance($this->loader);
    }

    (new CronjobController)->activate();

    register_deactivation_hook(STELLENANZEIGENE_PLUGIN_FILE, array($this, 'deactivate'));
    register_activation_hook(STELLENANZEIGENE_PLUGIN_FILE, array($this, 'activate'));
  }

  /**
   * Runns the loader to add all Actions filters and so on
   */
  public function run() {
    $this->loader->run();
  }


  /**
   * Define the locale for this plugin for internationalization.
   */
  private function set_locale() {
    $plugin_i18n = new I18nController();
    $this->loader->addAction('plugins_loaded', $plugin_i18n, 'load_plugin_textdomain', 1);
  }


  /**
   * Creates a new instance of this class if one hasn't already been made
   * and then returns the single instance of this class.
   */
  public static function instance() {
    if (!isset(self::$instance)) {
      self::$instance = new CoreController();
    }

    return self::$instance;
  }

  /**
   * This function deactivates the Plugin
   */
  public function deactivate() {
    DeactivationController::deactivate();
  }

  /**
   * This function activates the Plugin
   */
  public function activate() {
    // One time sync locations
    (new CronjobController)->getJobLocationDataEvery__1day__callback();
  }
}
