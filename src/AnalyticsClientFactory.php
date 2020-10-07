<?php

namespace Jflahaut\Analytics;


use Google_Client;
use Google_Exception;
use Google_Service_Analytics;

class AnalyticsClientFactory
{

    /**
     * @param array $config
     * @return AnalyticsClient
     * @throws Google_Exception
     */
    public static function CreateClient(array $config): AnalyticsClient
    {
        $authenticatedGoogleCLient = self::createAuthenticatedGoogleCLient($config);
        $service = new Google_Service_Analytics($authenticatedGoogleCLient);

        return self::createAnalyticsClient($service);
    }

    /**
     * @param array $config
     * @return Google_Client
     * @throws \Google_Exception
     */
    protected static function createAuthenticatedGoogleCLient(array $config): Google_Client
    {
        $client = new Google_Client();
        $client->setScopes([
            Google_Service_Analytics::ANALYTICS_READONLY,
        ]);
        $client->setAuthConfig($config['service_account_credentials_json']);

        return $client;
    }

    /**
     * @param Google_Service_Analytics $googleService
     * @return AnalyticsClient
     */
    protected static function createAnalyticsClient(Google_Service_Analytics $googleService): AnalyticsClient
    {
        return new AnalyticsClient($googleService);
    }

}