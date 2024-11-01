<?php

/**
 * Renders a filter to search for a radius
 */

namespace Stellenanzeigen\View\Components;

if (!defined('ABSPATH')) exit;
?>

<div class="stellenanzeigen__form_group radius">
    <label for="radius"><?php echo __('Searchradius', 'smartsearch-job-ads') ?></label>
    <select disabled="" name="radius" id="radius">
        <option value="0" selected>
            <?php echo __('0km', 'smartsearch-job-ads') ?>
        </option>
        <option value="5">
            <?php echo __('5km', 'smartsearch-job-ads') ?>
        </option>
        <option value="10">
            <?php echo __('10km', 'smartsearch-job-ads') ?>
        </option>
        <option value="15">
            <?php echo __('15km', 'smartsearch-job-ads') ?>
        </option>
        <option value="20">
            <?php echo __('20km', 'smartsearch-job-ads') ?>
        </option>
        <option value="30">
            <?php echo __('30km', 'smartsearch-job-ads') ?>
        </option>
        <option value="40">
            <?php echo __('40km', 'smartsearch-job-ads') ?>
        </option>
        <option value="50">
            <?php echo __('50km', 'smartsearch-job-ads') ?>
        </option>
        <option value="100">
            <?php echo __('100km', 'smartsearch-job-ads') ?>
        </option>
    </select>
</div>