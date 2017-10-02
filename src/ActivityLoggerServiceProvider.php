<?php

namespace JeroenG\ActivityLogger;

use Illuminate\Support\ServiceProvider;

class ActivityLoggerServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__.'/../migrations');

        $this->publishes([
            __DIR__.'/../migrations' => $this->app->databasePath().'/migrations',
        ]);
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('activitylogger', function ($app) {
            return new ActivityLogger;
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['activitylogger'];
    }
}
