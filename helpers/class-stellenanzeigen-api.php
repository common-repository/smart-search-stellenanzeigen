<?php

namespace Stellenanzeigen\Helpers;

if (!defined('ABSPATH')) exit;

/**
 * This Helper will be used to talk
 */
class StellenanzeigenApi {
  public $url = 'https://api.smartsearch.business';

  /**
   * Retreives all the Jobs from the API
   */
  public function getJobs($filter = null) {
    if (isset($filter['company']) && $filter['company'] != null) {
      $url = $this->url . '/' . md5(html_entity_decode($filter['company']));
    } else {
      $url = $this->url;
    }

    $response = wp_remote_get($url, array('timeout' => 10000));

    $response = json_decode($response['body']);

    return $response;
  }
}
