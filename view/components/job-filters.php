<?php

/**
 * Renders the filters
 */

namespace Stellenanzeigen\View\Components;

use Stellenanzeigen\View\Render;

if (!defined('ABSPATH')) exit;

?>

<div class="filter_jobs_container">
    <div class="filter_search">
        <?php echo Render::view('components/search-bar', array()); ?>
    </div>
    <div class="filters">
        <?php echo Render::view('components/location-filter', array()); ?>
        <div class="city_filter">
            <?php echo Render::view('components/city-filter', array()); ?>
        </div>
        <?php echo Render::view('components/zip-filter', array()); ?>
        <?php echo Render::view('components/radius-filter', array()); ?>
    </div>
    <div class="filter_search">
        <button id="filter_jobs_search"><?php echo __('Search', 'smartsearch-job-ads') ?></button>
    </div>
    <?php wp_nonce_field('jobs_ajaxFilter', 'jobs_ajaxFilter_name'); ?>
    <br>
</div>