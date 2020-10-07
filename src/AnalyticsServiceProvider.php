<?php

namespace Jflahaut\Analytics;


use Illuminate\Support\ServiceProvider;

class AnalyticsServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/analytics.php' => config_path('analytics.php'),
        ]);
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/analytics.php', 'analytics');

        $this->app->singleton(AnalyticsClient::class, function ($app) {
            $config = config('analytics');
            return AnalyticsClientFactory::CreateClient($config);
        });

        $this->app->singleton(Analytics::class, function ($app) {
            $client = resolve(AnalyticsClient::class);
            return new Analytics($client);
        });

    }

}