<?php

/**
 * Component to render a Location Select field
 */


namespace Stellenanzeigen\View\Components;

if (!defined('ABSPATH')) exit;

$jobs_regions = get_option('stellenanzeigen_jobs_regions');
?>
<div class="stellenanzeigen__form_group location">
    <label for="location"><?php echo __('Select region', 'smartsearch-job-ads') ?></label>
    <select name="location" id="location">
        <option value="all" selected>
            <?php echo __('All', 'smartsearch-job-ads') ?>
        </option>
        <?php foreach ($jobs_regions as $key => $region) { ?>
            <option value="<?php echo strtolower(esc_html($region)); ?>">
                <?php echo esc_html($region); ?>
            </option>
        <?php } ?>
    </select>
</div>