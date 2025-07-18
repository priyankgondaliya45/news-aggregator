<?php

namespace App\Providers;

use App\Services\News\GuardianApiService;
use App\Services\News\NewsAggregatorService;
use App\Services\News\NewsApiService;
use App\Services\News\NewYorkTimesApiService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->tag([
            NewsApiService::class,
            NewYorkTimesApiService::class,
            GuardianApiService::class,
        ], 'news_integrations');

        $this->app->singleton(NewsAggregatorService::class, function ($app) {
            return new NewsAggregatorService($app->tagged('news_integrations'));
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
