<?php

namespace Jflahaut\Analytics;

use DateTime;
use Google_Service_Analytics;
use Google_Service_Analytics_GaData;

class AnalyticsClient
{

    protected $service;

    /**
     * AnalyticsClient constructor.
     * @param Google_Service_Analytics $service
     */
    public function __construct(Google_Service_Analytics $service)
    {
        $this->service = $service;
    }

    /**
     * @param string $viewId
     * @param DateTime $startDate
     * @param DateTime $endDate
     * @param string $metrics
     * @param array $options
     * @return Google_Service_Analytics_GaData
     */
    public function query(string $viewId, DateTime $startDate, DateTime $endDate, string $metrics, array $options = []): Google_Service_Analytics_GaData
    {
        return $this->service->data_ga->get(
            "ga:{$viewId}",
            $startDate->format('Y-m-d'),
            $endDate->format('Y-m-d'),
            $metrics,
            $options
        );
    }

}
