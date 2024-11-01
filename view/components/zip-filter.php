<?php

/**
 * Renders a zip filter
 */

namespace Stellenanzeigen\View\Components;

if (!defined('ABSPATH')) exit;

?>

<div class="stellenanzeigen__form_group zip">
  <label for="zip"><?php echo __('Zipcode', 'smartsearch-job-ads') ?></label>
  <input type="text" id="zip" name="zip" placeholder="">
</div>