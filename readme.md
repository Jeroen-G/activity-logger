Activity Logger
=====================

A simple activity logger for Laravel.

[![Build Status](https://travis-ci.org/Jeroen-G/activity-logger.png?branch=master)](https://travis-ci.org/Jeroen-G/activity-logger)
[![Scrutinizer Quality Score](https://scrutinizer-ci.com/g/Jeroen-G/activity-logger/badges/quality-score.png?s=a0e8e2ce3e6f07bb1171e5257b3224a60427bb3c)](https://scrutinizer-ci.com/g/Jeroen-G/activity-logger/)
[![Latest Stable Version](https://poser.pugx.org/jeroen-g/activity-logger/v/stable.png)](https://packagist.org/packages/jeroen-g/activity-logger)

## Installation ##

Add this line to your `composer.json`

	"jeroen-g/activity-logger": "dev-master"

Then update Composer

    composer update

Add the service provider in `app/config/app.php`:

    'JeroenG\ActivityLogger\ActivityLoggerServiceProvider',

And in the same file, add the alias:

	'Activity'		  => 'JeroenG\ActivityLogger\Facades\ActivityLogger',

Then migrate to create the table for the activities

	php artisan migrate --package="jeroen-g/activity-logger"

## Usage ##

### Log an activity ###

```php
Activity::log($message, $context, $date);
```

Message is required, the rest is optional. $context is an array which can contain any data you want to save. $date is a timestamp, it defaults to the current timestamp.

### Get all logs ###

```php
Activity::getAllLogs();
```

### Get one log ###

You only need to pass the id of a log.


```php
Activity::getLog(1);
```

### Get all logs within timespan ###

```php
$yesterday = Carbon\Carbon::yesterday();
$tomorrow = Carbon\Carbon::tomorrow();

Activity::getLogsBetween($yesterday, $tomorrow);
```

This function needs two parameters, all logs created between these timestamps are returned.