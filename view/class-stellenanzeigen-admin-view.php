<?php

namespace Stellenanzeigen\View;

use Stellenanzeigen\View\Render;

if (!defined('ABSPATH')) exit;


/**
 * Administration view
 */
class StellenanzeigenAdminView {
  public function render() {
    ob_start();

    echo Render::view('components/header', array());
?>
    <div class="stellenanzerigen__main_wrapper">
      <?php
      echo Render::view('components/sidebar', array());

      if (isset($_GET['smart-search-page']) && $_GET['smart-search-page'] == 'shortcode') {
        echo Render::view('components/shortcode-generator-form', array());
      } else {
        echo Render::view('components/how-to-use', array('shortcode' => 'job_list'));
      }
      ?>
    </div>
<?php
    $contents = ob_get_contents();
    ob_end_clean();
    return $contents;
  }
}
