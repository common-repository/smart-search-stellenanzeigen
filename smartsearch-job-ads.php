<?php

/**
 * @package Stellenanzeigen
 *
 * Plugin Name: SMART SEARCH job ads
 * Plugin URI: https://wordpress.org/plugins/stellenanzeigen/
 * Description: Online Personalabteilung - Joblisting und Multiposting Manager / Alle Jobs automatisch auf deiner Website inkl. Multiposting in Meta-Jobbörsen, Google for Jobs, Suchmaschinen und der Bundesagentur für Arbeit inkl. Bewerbermanagementsytem mit automatischem Email-Schriftverkehr, DSGVO-konform uvm.
 * Author: Mediawerkstatt Bodensee
 * Version: 1.0.4
 * Author URI: https://mediawerkstatt-bodensee.de/
 * Text Domain: smartsearch-job-ads
 * Domain Path: /languages
 * License: GPL2+
 */


namespace Stellenanzeigen;

use Stellenanzeigen\Controllers\CoreController;


// Exit if accessed directly.
if (!defined('ABSPATH')) exit;


/**
 * With this function we can log to the console
 * if logs does not appear check wp-config.php (WP_DEBUG)
 */
if (!function_exists('write_log')) {
  function write_log($log) {

    if (is_array($log) || is_object($log)) {
      error_log(print_r($log, true));
    } else {
      error_log($log);
    }
  }
}

/**
 * With this function we can print dumps on the screen
 * if dump does not appear check wp-config.php (WP_DEBUG)
 */
if (!function_exists('write_dump')) {
  function write_dump($log) {
    if (true) {
      if (is_array($log) || is_object($log)) {
        echo "<pre>";
        var_dump($log);
        echo "</pre>";
      } else {
        var_dump($log);
      }
    }
  }
}


if (!defined('STELLENANZEIGENE_PLUGIN_FILE')) {
  /**
   * Plugin Root File.
   */
  define('STELLENANZEIGENE_PLUGIN_FILE', __FILE__);
}


if (!defined('STELLENANZEIGENE_PATH')) {
  /**
   * This is the path to the plugin directory
   */
  define('STELLENANZEIGENE_PATH', wp_normalize_path(plugin_dir_path(__FILE__)));
}

if (!defined('STELLENANZEIGENE_PLUGIN_ID')) {
  /**
   * This is the plugins ID
   */
  define('STELLENANZEIGENE_PLUGIN_ID', 'smartsearch-job-ads');
}

if (!defined('STELLENANZEIGENE_URL')) {
  /**
   * This is the URL to the plugin directory
   */
  define('STELLENANZEIGENE_URL', plugin_dir_url(__FILE__));
}

if (!defined('STELLENANZEIGENE_CAPABILITY')) {
  /**
   * This is the capability the plugin can use
   */
  define('STELLENANZEIGENE_CAPABILITY', 'manage_options');
}

// Autoloading things
require __DIR__ . '/includes/class-autoloader.php';
(new Autoloader())->register();

/**
 * Initialize this plugin
 */
function run() {
  $stellenanzeigen = CoreController::instance();
  $stellenanzeigen->run();
};

run();
