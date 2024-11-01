<?php

namespace Stellenanzeigen\View\Components;

if (!defined('ABSPATH')) exit;

?>

<img
  src="https://flagcdn.com/16x12/<?php echo esc_html($location) ?>.png"
  srcset="https://flagcdn.com/32x24/<?php echo esc_html($location) ?>.png 2x, https://flagcdn.com/48x36/<?php echo esc_html($location) ?>.png 3x"
  width="16"
  height="12"
  alt="South Africa"
>