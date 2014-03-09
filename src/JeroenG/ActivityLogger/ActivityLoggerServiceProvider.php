<?php namespace JeroenG\ActivityLogger;

use Illuminate\Support\ServiceProvider;

/**
 * This is the service provider for Laravel.
 *
 * Place the line below in the providers array inside app/config/app.php
 * <code>'JeroenG\ActivityLogger\ActivityLoggerServiceProvider',</code>
 *
 * @package ActivityLogger
 * @author 	JeroenG
 * 
 **/
class ActivityLoggerServiceProvider extends ServiceProvider {

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
		$this->package('jeroen-g/activity-logger');
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app['activitylogger'] = $this->app->share( function ($app)
            {
                return new ActivityLogger;
            }
        );
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array('activitylogger');
	}

}
