<?php

namespace Stellenanzeigen\Helpers;

if (!defined('ABSPATH')) exit;

/**
 * This Helper is responsible to work with Stellenanzeigen job postings.
 * It will be used Mainly for filtering and searching through job postings
 */
class StellenanzeigenFunctions {

    /**
     * Stores all the possible types of filters
     */
    public $filter_types = array(
        'jobs_ids' => 'jobs_ids',
        'ajaxFilter' => 'ajaxFilter',
        'type' => 'type',
        'industry' => 'industry',
        'hide_type' => 'hide_type',
        'hide_initiative' => 'hide_initiative',
    );

    /**
     * Stores the filter mapping
     */
    public $filter_mapping;

    /**
     * Seperator used to seperate Items on the filter
     */
    public $seperator = ';';

    /**
     * Constructor.
     * Builds up the functions.
     */
    public function __construct() {
        $this->addFilterMapping();
    }

    /**
     * Adds a Filter Mapping.
     */
    private function addFilterMapping() {
        $this->filter_mapping = array(
            $this->filter_types['jobs_ids'] => function ($jobs_ids) {
                return function ($jobs) use ($jobs_ids) {
                    $to_return = false;

                    $results = explode($this->seperator, $jobs_ids);
                    if (count($results) > 1) {
                        foreach ($results as $result) {
                            if (!$to_return) {
                                $to_return = strtolower(trim($jobs->jobId)) == strtolower(trim($result));
                            }
                        }
                    } else {
                        return strtolower(trim($jobs->jobId)) == strtolower(trim($jobs_ids));
                    }
                    return $to_return;
                };
            },
            $this->filter_types['ajaxFilter'] => function ($ajaxFilterData) {
                $results = explode($this->seperator, $ajaxFilterData);
                $search = $results[0];
                $location = $results[1];
                $radius = $results[2];
                $city = $results[3];
                $zip = $results[4];

                if ($city !== 'all' || $location !== 'all') {
                    $url = "http://nominatim.openstreetmap.org/search?q=$city&format=json";
                    $mapApiResponse = wp_remote_get($url);
                    if (is_wp_error($mapApiResponse)) {
                        return;
                    }
                    $res = json_decode($mapApiResponse['body']);
                    $locationCenterCoord = array($res[0]->lat, $res[0]->lon);
                } else {
                    $locationCenterCoord = get_option('stellenanzeigen_jobs_regions_coordinates')[ucwords($location, "\t\r\n\f\v'\-\ ")];
                }

                return function ($jobs) use ($locationCenterCoord, $location, $search, $radius, $city, $zip) {
                    $locationFilter = false;
                    $searchFilter = false;
                    $radiusFilter = false;
                    $cityFilter = false;
                    $zipFilter = false;

                    if ($search !== '') {
                        $searchFilter = str_contains(strtolower(trim($jobs->jobTitle)), strtolower($search));

                        // If Search is not met we will immediatly return false
                        if (!$searchFilter) return false;
                    }

                    // If radius was set we have to combine each location filter with a radius
                    if ($radius !== '0' && $location !== 'all' && $city !== 'all') {
                        if ($location !== 'all') {
                            $locationFilter = strtolower(trim($jobs->jobRegion)) == strtolower($location);
                        }
                        if ($city !== 'all') {
                            $cityFilter = strtolower(trim($jobs->jobWorkplace)) == strtolower($city);
                        }
                        if ($zip !== '') {
                            $zipFilter = strtolower(trim($jobs->jobWorkplaceZipcode)) == strtolower($zip);
                        }

                        $jobLatitude = trim($jobs->jobLatitude);
                        $jobLongitude = trim($jobs->jobLongitude);

                        $radiusFilter = $this->areCoordinatesWithinRadius(
                            [$jobLatitude, $jobLongitude],
                            $locationCenterCoord,
                            $radius
                        );
                    } else {
                        if ($location !== 'all') {
                            $locationFilter = strtolower(trim($jobs->jobRegion)) == strtolower($location);
                        } else {
                            $locationFilter = true;
                        }

                        if ($city !== 'all') {
                            $cityFilter = strtolower(trim($jobs->jobWorkplace)) == strtolower($city);
                        } else {
                            $cityFilter = true;
                        }

                        if ($zip !== '') {
                            $zipFilter = strtolower(trim($jobs->jobWorkplaceZipcode)) == strtolower($zip);

                            // If Zip is not met we will immediatly return false
                            if (!$zipFilter) return false;
                        }
                    }
                    $location_and_filter_combination = ($city !== 'all') ? ($locationFilter && $cityFilter) : $locationFilter;
                    $filter_result = ($search !== '') ? $searchFilter && ($location_and_filter_combination || $radiusFilter || $zipFilter) : ($location_and_filter_combination || $radiusFilter || $zipFilter);

                    return $filter_result;
                };
            },
            $this->filter_types["type"] => function ($type) {
                return function ($jobs) use ($type) {
                    $to_return = false;

                    $results = explode($this->seperator, $type);
                    if (count($results) > 1) {
                        foreach ($results as $result) {
                            if (!$to_return) {
                                $to_return = strtolower(trim($jobs->jobEmploymentType)) == strtolower(trim($result));
                            }
                        }
                    } else {
                        return strtolower(trim($jobs->jobEmploymentType)) == strtolower(trim($type));
                    }
                    return $to_return;
                };
            },
            $this->filter_types['industry'] => function ($industry) {
                return function ($jobs) use ($industry) {
                    $to_return = false;

                    $results = explode($this->seperator, $industry);

                    if (count($results) > 1) {
                        foreach ($results as $result) {
                            if (!$to_return) {
                                $to_return = strtolower(trim($jobs->jobIndustry)) == strtolower(trim($result));
                            }
                        }
                    } else {
                        $to_return = strtolower(trim($jobs->jobIndustry)) == strtolower(trim($industry));
                    }

                    return $to_return;
                };
            },
            $this->filter_types['hide_type'] => function ($hide_type) {
                return function ($jobs) use ($hide_type) {
                    $to_return = false;

                    $results = explode($this->seperator, $hide_type);

                    if (count($results) > 1) {
                        foreach ($results as $result) {
                            if (!$to_return) {
                                $to_return = strtolower(trim($jobs->jobEmploymentType)) != strtolower(trim($result));
                            }
                        }
                    } else {
                        $to_return = strtolower(trim($jobs->jobEmploymentType)) != strtolower(trim($hide_type));
                    }

                    return $to_return;
                };
            },
            $this->filter_types['hide_initiative'] => function () {
                return function ($jobs) {
                    $to_return = false;

                    $results = explode($this->seperator, 'Initiativbewerbung');

                    if (count($results) > 1) {
                        foreach ($results as $result) {
                            if (!$to_return) {
                                $to_return = strtolower(trim($jobs->jobEmploymentType)) != strtolower(trim($result));
                            }
                        }
                    } else {
                        $to_return = strtolower(trim($jobs->jobEmploymentType)) != strtolower(trim('Initiativbewerbung'));
                    }

                    return $to_return;
                };
            },
        );
    }

    /**
     * Checks whether coordinates are withing the radius or not
     */
    private function areCoordinatesWithinRadius($coordinateArray, $center, $radius) {
        $result = false;
        $lat1 = $center[0];
        $long1 = $center[1];
        $lat2 = $coordinateArray[0];
        $long2 = $coordinateArray[1];
        $distance = 3959 * acos(cos($this->radians($lat1)) * cos($this->radians($lat2))
            * cos($this->radians($long2) - $this->radians($long1))
            + sin($this->radians($lat1)) * sin($this->radians($lat2)));
        if ($distance < $radius) $result = true;
        return $result;
    }

    /**
     * Calculates a radian for coordinates search
     */
    private function radians($deg) {
        return floatval($deg) * M_PI / 180;
    }

    /**
     * Filters all the given Jobs by given filters
     */
    public function filter_jobs($jobs, $filters = null) {
        $to_return = $jobs;

        if ($filters) {
            foreach ($filters as $key => $filter) {
                if ($filter !== null && in_array($key, $this->filter_types) && isset($this->filter_mapping[$key]) && $this->filter_mapping[$key] != null) {
                    $to_return = array_filter($to_return, $this->filter_mapping[$key]($filter));
                }
            }
        }
        return $to_return;
    }

    /**
     * Returns the Date of a Job posting
     */
    public static function getDate($xml) {
        return $xml->jobPublishingDateFrom;
    }
}
