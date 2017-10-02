Activity Logger
=====================

A simple activity logger for Laravel.

[![Scrutinizer Quality Score](https://scrutinizer-ci.com/g/Jeroen-G/activity-logger/badges/quality-score.png?s=bd15e13c2a26810c8109bc1f4d7569c06f5d916c)](https://scrutinizer-ci.com/g/Jeroen-G/activity-logger/)
[![Latest Stable Version](https://img.shields.io/github/release/jeroen-g/activity-logger.svg?style=flat)](https://github.com/jeroen-g/activity-logger/releases)
[![License](https://img.shields.io/badge/License-EUPL--1.1-blue.svg?style=flat)](license.md)


## Installation ##

Via Composer
``` bash
$ composer require jeroen-g/activity-logger
```

The following command installs the package without the testing requirements.
``` bash
$ composer require jeroen-g/activity-logger --update-no-dev
```

Laravel 5.5 automatically installs the package, for previous versions, follow the next two steps. After that, don't forget to run `php artisan migrate`
Add the service provider in `config/app.php`:

    JeroenG\ActivityLogger\ActivityLoggerServiceProvider::class,

And in the same file, add the alias:

	'Activity' =>  JeroenG\ActivityLogger\Facades\ActivityLogger::class,

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

### Get the most recent logs ###

```php
Activity::getRecentLogs(10);
```

The default of 5 logs is used when no number is passed.