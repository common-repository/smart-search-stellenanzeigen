<?php
if (!defined('WP_UNINSTALL_PLUGIN')) {
  die;
}

/**
 * Removes all Data since a user should have a clean Wordpress after uninstallation.
 */
function stellenanzeigen_uninstall() {
  // Delete all options
  delete_option('stellenanzeigen_jobs_regions_coordinates');
}

stellenanzeigen_uninstall();
