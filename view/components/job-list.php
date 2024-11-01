<?php

/**
 * Renders the Jobs list
 */

namespace Stellenanzeigen\View\Components;

use Stellenanzeigen\View\Render;

if (!defined('ABSPATH')) exit;

?>

<?php
if (isset($hover_color)) {
?>
  <style>
    .stellenanzeigen__joblist_item:hover {
      background-color: <?php echo esc_html(strtoupper($hover_color)) ?> !important;
      color: #fff !important;
      transform: scale(1.04);
    }
  </style>
<?php
}
?>
<div class="stellenanzeigen__joblist">
  <div>
    <p><?php echo sprintf(__('Number of Ads shown', 'smartsearch-job-ads'), count($jobs)) ?></p>
  </div>
  <ul class="stellenanzeigen__joblist_list">
    <?php
    foreach ($jobs as $job) {
      echo Render::view('components/job-list-item', array('job' => $job));
    }
    ?>
  </ul>
</div>