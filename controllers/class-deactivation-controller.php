<?php

namespace Stellenanzeigen\Controllers;

if (!defined('ABSPATH')) exit;

/**
 * This Controller is responsible for plugin deactivation
 * It will handle to delete everything which is not needed while the plugin is inactive
 */
class DeactivationController {
    public static function deactivate() {
        $stellenanzeigen_jobs_regions = get_option('stellenanzeigen_jobs_regions');
        $stellenanzeigen_jobs_regions_coordinates = get_option('stellenanzeigen_jobs_regions_coordinates');
        if(!empty($stellenanzeigen_jobs_regions)) {
            delete_option('stellenanzeigen_jobs_regions');
        }
        if(!empty($stellenanzeigen_jobs_regions_coordinates)) {
            delete_option('stellenanzeigen_jobs_regions_coordinates');
        }
        // Clear wp cron tasks
        wp_clear_scheduled_hook( 'getJobLocationDataEvery__1day' );
    }
}