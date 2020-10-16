<?php

namespace Jflahaut\Analytics;

use DateTime;
use Illuminate\Support\Collection;
use Google_Service_Analytics_GaData;
use Jflahaut\Analytics\Period\Period;

class Analytics
{
    protected $client;

    /**
     * Analytics constructor.
     * @param AnalyticsClient $client
     */
    public function __construct(AnalyticsClient $client)
    {
        $this->client = $client;
    }

    /**
     * @param string $viewId
     * @param Period $period
     * @return Collection
     */
    public function getVisitorsAndPageViews(string $viewId, Period $period): Collection
    {
        $response = $this->query(
            $viewId,
            $period,
            'ga:users,ga:pageviews',
            ['dimensions' => 'ga:date,ga:pageTitle']
        );

        return collect($response['rows'] ?? [])->map(function (array $dateRow) {
            return [
                'date' => DateTime::createFromFormat('Ymd', $dateRow[0])->format('Y-m-d'),
                'pageTitle' => $dateRow[1],
                'visitors' => (int) $dateRow[2],
                'pageViews' => (int) $dateRow[3],
            ];
        });
    }

    /**
     * @param $viewId
     * @param Period $period
     * @param string $metrics
     * @param array $options
     * @return Google_Service_Analytics_GaData
     */
    public function query($viewId, Period $period, string $metrics, $options = []): Google_Service_Analytics_GaData
    {
        return $this->client->query(
            $viewId,
            $period->getStartDate(),
            $period->getEndDate(),
            $metrics,
            $options
        );
    }
}