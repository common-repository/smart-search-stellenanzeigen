<?php

namespace Stellenanzeigen\Controllers;

use Stellenanzeigen\View\StellenanzeigenAdminView;

if (!defined('ABSPATH')) exit;

/**
 * The BackendController
 * It is responsible for everything running on admin side
 */
class BackendController {
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

    $this->addBackendActionHooks();
  }

  /**
   * The object is created from within the class itself
   * only if the class has no instance.
   */
  public static function getInstance($loader) {
    if (null === self::$instance) {
      self::$instance = new BackendController($loader);
    }

    return self::$instance;
  }

  /**
   * Add all Hooks for the Backend
   */
  private function addBackendActionHooks() {
    $this->loader->addAction('admin_menu', $this, 'add_admin_menu', 9);
    $this->loader->addAction('admin_enqueue_scripts', $this, 'admin_enqueues');
  }

  /**
   * Adds a the new item to the admin menu.
   */
  public function add_admin_menu() {
    $this->menu_id = add_menu_page(
      'Stellenanzeigen',
      'Stellenanzeigen',
      STELLENANZEIGENE_CAPABILITY,
      STELLENANZEIGENE_PLUGIN_ID,
      function () {
        $admin_view = new StellenanzeigenAdminView();
        echo $admin_view->render($this);
      },
      STELLENANZEIGENE_URL . 'assets/logo-icon.svg'
    );
  }

  /**
   * Enqueues JavaScript file and stylesheets on the plugin's admin page.
   */
  public function admin_enqueues($hook_suffix) {
    if ($hook_suffix != $this->menu_id) {
      return;
    }

    wp_enqueue_style(
      'stellenanzeigen_css',
      STELLENANZEIGENE_URL . '/assets/style.css',
    );
    wp_enqueue_style(
      'stellenanzeigen_backend_css',
      STELLENANZEIGENE_URL . '/assets/backend-style.css',
    );

    wp_enqueue_script(
      'stellenanzeigen_script',
      STELLENANZEIGENE_URL . '/assets/script.js',
      array('wp-api-request', 'jquery')
    );
  }
}
