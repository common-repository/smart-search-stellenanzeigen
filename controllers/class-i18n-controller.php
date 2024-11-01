<?php

namespace Stellenanzeigen\Controllers;

if (!defined('ABSPATH')) exit;


/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 */
class I18nController {
  /**
   * Load the plugin text domain for translation.
   */
  public function load_plugin_textdomain() {
    load_plugin_textdomain(
      STELLENANZEIGENE_PLUGIN_ID,
      false,
      'smart-search-stellenanzeigen/languages',
    );
  }
}
