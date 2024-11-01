<?php

/**
 * Renders a single Job item
 */

namespace Stellenanzeigen\View\Components;

use Stellenanzeigen\View\Render;

if (!defined('ABSPATH')) exit;

$url = $job->jobOffer;

if (!preg_match("~^(?:f|ht)tps?://~i", $url)) {
  // If not exist then add http
  $url = "https://" . $url;
}

?>

<li class="stellenanzeigen__joblist_item">
  <a href="<?php echo esc_html($url) ?>">
    <?php echo Render::view('components/flag', array('location' => 'de')) ?>
    <h3><?php echo esc_html($job->jobTitle) ?></h3>
    <p><?php echo esc_html($job->contactCompany) . ', ' . esc_html($job->jobWorkplaceZipcode) . ' ' . esc_html($job->jobWorkplace) ?></p>
    <p><?php echo esc_html($job->jobIndustry) ?></p>
  </a>
</li>