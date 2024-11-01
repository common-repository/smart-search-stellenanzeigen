<?php

namespace Stellenanzeigen\View\Components;

if (!defined('ABSPATH')) exit;

/**
 * Component to render a City Select field
 */

$has_cities = isset($cities) && count($cities) > 0;
?>
<div class="stellenanzeigen__form_group zip">
    <label for="city"><?php echo __('City', 'smartsearch-job-ads') ?></label>
    <select <?php echo ($has_cities == false) ? 'disabled' : '' ?> name="city" id="city">
        <option value="all" selected>
            <?php echo  $has_cities ? __('All', 'smartsearch-job-ads') : __('Please select a region', 'smartsearch-job-ads') ?>
        </option>
        <?php
        if ($has_cities) {
            foreach ($cities as $city) {
                echo '<option value="' . esc_html(strtolower($city)) . '">' . esc_html($city) . '</option>';
            }
        }
        ?>
    </select>
</div>