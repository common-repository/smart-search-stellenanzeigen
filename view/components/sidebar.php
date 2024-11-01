<?php

namespace Stellenanzeigen\View\Components;

if (!defined('ABSPATH')) exit;

?>

<asside class="stellenanzerigen__sidebar">
  <nav>
    <a href="<?php echo esc_url( add_query_arg( 'smart-search-page', "main" ) )?>">
      <div class="stellenanzerigen__sidebar-nav-item <?php if(isset($_GET['smart-search-page']) && $_GET['smart-search-page'] === 'main') echo("active"); ?>">
        Main
      </div>
    </a>
    <a href="<?php echo esc_url( add_query_arg( 'smart-search-page', "shortcode" ) )?>">
    <div class="stellenanzerigen__sidebar-nav-item <?php if(isset($_GET['smart-search-page']) && $_GET['smart-search-page'] === 'shortcode') echo("active"); ?>">
      Shortcode
    </div>
    </a>
  </nav>
</asside>