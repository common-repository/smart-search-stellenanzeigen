<?php

namespace Stellenanzeigen\View\Components;

if (!defined('ABSPATH')) exit;

/**
 * Renders a how to use Card
 */

?>

<div class="stellenanzeigen__wrapper">
  <h1 class="stellenanzeigen__headline">
    <?php echo __("How to use this plugin", "smartsearch-job-ads") ?>
  </h1>

  <pre class="stellenanzeigen__shortcode_viewer">
    [<?php echo esc_html($shortcode) ?>]
  </pre>

  <h3 class="stellenanzeigen__headline">company</h3>
  <pre class="stellenanzeigen__shortcode_viewer">
    [<?php echo esc_html($shortcode) ?> company="<?php echo __('Name of the company', 'smartsearch-job-ads') ?>"]
  </pre>

  <h3 class="stellenanzeigen__headline">industry</h3>
  <pre class="stellenanzeigen__shortcode_viewer">
    [<?php echo esc_html($shortcode) ?> industry="<?php echo __('Name of the company', 'smartsearch-job-ads') ?>"]
  </pre>

  <h3 class="stellenanzeigen__headline">jobs_ids</h3>
  <pre class="stellenanzeigen__shortcode_viewer">
    [<?php echo esc_html($shortcode) ?> jobs_ids="6;7"]
  </pre>

  <h3 class="stellenanzeigen__headline"><?php echo __('Joblist with filters', 'smartsearch-job-ads') ?></h3>
  <pre class="stellenanzeigen__shortcode_viewer">
    [<?php echo esc_html($shortcode) ?> with_filter=true]
  </pre>

  <h3 class="stellenanzeigen__headline">type</h3>
  <pre class="stellenanzeigen__shortcode_viewer">
    [<?php echo esc_html($shortcode) ?> type="<?php echo __('Type of ad', 'smartsearch-job-ads') ?>"]
  </pre>

  <h3 class="stellenanzeigen__headline">hide_type</h3>
  <p><?php echo __('With this filter you can hide types', 'smartsearch-job-ads') ?></p>
  <pre class="stellenanzeigen__shortcode_viewer">
    [<?php echo esc_html($shortcode) ?> hide_type="<?php echo __('Type of ad', 'smartsearch-job-ads') ?>"]
  </pre>

  <h3 class="stellenanzeigen__headline">hide_initiative</h3>
  <p><?php echo __('With this filter you can hide initiative ads', 'smartsearch-job-ads') ?></p>
  <pre class="stellenanzeigen__shortcode_viewer">
    [<?php echo esc_html($shortcode) ?> hide_initiative=true]
  </pre>

  <h3 class="stellenanzeigen__headline">Hover Color</h3>
  <p><?php echo __('With this attribute you can customize the color that is displayed when the mouse hovers over the element', 'smartsearch-job-ads') ?></p>
  <pre class="stellenanzeigen__shortcode_viewer">
    [<?php echo esc_html($shortcode) ?> hover_color="#000"]
  </pre>

  <h2><?php echo __('Semicolon separated filters', 'smartsearch-job-ads') ?></h2>
  <p><?php echo __('For each filter you can append several filters to each other by semicolon', 'smartsearch-job-ads') ?></p>
  <pre class="stellenanzeigen__shortcode_viewer">
    [<?php echo esc_html($shortcode) ?> type="typ1;typ2;typ3"]
  </pre>
</div>