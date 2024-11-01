<?php

namespace Stellenanzeigen\Controllers;

use Stellenanzeigen\Helpers\StellenanzeigenApi;

if (!defined('ABSPATH')) exit;

/**
 * Cron
 * This class defines all code necessary to cron schedules.
 */
class CronjobController {

    /**
     * Activates the Cronjob
     */
    public function activate(){
        add_action( 'getJobLocationDataEvery__1day', array($this, 'getJobLocationDataEvery__1day__callback'));
        if ( !wp_get_schedule( 'getJobLocationDataEvery__1day' )){
            wp_schedule_event( time(), 'daily', 'getJobLocationDataEvery__1day');
        }
    }

    /**
     * Retreives the Regions for Jobs
     */
    public function getJobLocationDataEvery__1day__callback(){
        $api = new StellenanzeigenApi();
        $jobs = $api->getJobs();
        $jobs_regions = array();
        $jobs_city__ununique = array();

        foreach ((array)$jobs as $job) {
            if((string)$job->jobRegion){
                $jobs_regions[] = (string)$job->jobRegion;
                $jobs_city__ununique[strtolower((string)$job->jobRegion)][] = (string)$job->jobWorkplace;
            }
        }
        $jobs_city__unique = array();
        foreach ($jobs_city__ununique as $key=>$job) {
            $jobs_city__unique[$key] = array_unique($job);
        }
        $jobs_regions = array_unique($jobs_regions);
        sort($jobs_regions);
        update_option('stellenanzeigen_jobs_regions',$jobs_regions);
        update_option('stellenanzeigen_jobs_city',$jobs_city__unique);

        $addressData = array();
        foreach($jobs_regions as $address){
            if(str_contains($address, ' ')){
                str_replace(' ', '%20', $address);
            }

            $mapApiResponse = wp_remote_get('https://nominatim.openstreetmap.org/search?q='.$address.'&format=json&polygon=0&addressdetails=1');
            $mapApiResponse = json_decode($mapApiResponse['body']);
            if($mapApiResponse){
                $addressLocation_lat = $mapApiResponse[0]->lat;
                $addressLocation_lng = $mapApiResponse[0]->lon;
                $addressData[$address] = [$addressLocation_lat, $addressLocation_lng];
            }
        }
        update_option('stellenanzeigen_jobs_regions_coordinates',$addressData);
    }
}