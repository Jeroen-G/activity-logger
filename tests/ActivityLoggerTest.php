<?php

//use Mockery as m;
use Illuminate\Foundation\Testing\TestCase;
use JeroenG\ActivityLogger\ActivityLogger;

/**
 * This is for testing the package
 *
 * @package ActivityLogger
 * @subpackage Tests
 * @author  JeroenG
 * 
 **/
class ActivityLoggerTest extends TestCase
{
    /**
     * Boots the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        die(var_dump(app_path()));
        $app = require __DIR__.'/../vendor/laravel/laravel/bootstrap/app.php';

        $app->register('JeroenG\ActivityLogger\ActivityLoggerServiceProvider');

        $app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

        return $app;      
    }

    /**
     * Setup DB before each test.
     *
     * @return void  
     */
    public function setUp()
    { 
        parent::setUp();

        $this->app['config']->set('database.default','sqlite'); 
        $this->app['config']->set('database.connections.sqlite.database', ':memory:');

        $this->migrate();

        $this->logger = new ActivityLogger();
    }

    /**
     * run package database migrations
     *
     * @return void
     */
    public function migrate()
    { 
        $classFinder = $this->app->make('Illuminate\Filesystem\ClassFinder');
        
        $path = realpath(__DIR__ . "/../src/migrations");
        $files = glob($path.'/*');

        foreach($files as $file)
        {
            require_once $file;
            $migrationClass = $classFinder->findClass($file);

            (new $migrationClass)->up();
        }
    }

    public function testAddingSimpleLog()
    {
        $log = $this->logger->log('Hello Universe');
        $this->assertObjectHasAttribute('attributes', $log, 'Adding a simple log failed');
    }

    /**
     * Test adding a log with message and context.
     *
     * @test
     */
    public function testAddingLogWithContext()
    {
        $log = $this->logger->log('Hello ', array('greeting' => 'universe', 'awesomeness' => 9000));
        $this->assertObjectHasAttribute('attributes', $log, 'Adding a log with context failed');
    }
    /**
     * Test adding a log with message, context and date.
     *
     * @test
     */
    public function testAddingLogWithContextAndDate()
    {
        $yesterday = Carbon\Carbon::yesterday();
        $log = $this->logger->log('Hello ', array('greeting' => 'universe'), $yesterday);
        $this->assertObjectHasAttribute('attributes', $log, 'Adding a log with context and date failed');
    }
    /**
     * Test getting all logs.
     *
     * @test
     */
    public function testGettingAllLogs()
    {
        $logs = $this->logger->getAllLogs();
        $this->assertObjectHasAttribute('items', $logs, 'Getting all logs failed');
    }
    /**
     * Test getting a single log.
     *
     * @test
     */
    public function testGettingSingleLog()
    {
        $log = $this->logger->log('Hello Universe');
        $log = $this->logger->getLog(1);
        $this->assertNotNull($log);
    }
    /**
     * Test getting all logs created between yesterday and tomorrow.
     *
     * @test
     */
    public function testGettingLogsInTimespan()
    {
        $tomorrow = Carbon\Carbon::tomorrow();
        $yesterday = Carbon\Carbon::yesterday();
        $logs = $this->logger->getLogsBetween($yesterday, $tomorrow);
        $this->assertNotNull($logs);
    }
    /**
     * Test getting the most recent logs.
     *
     * @test
     */
    public function testGettingRecentLogs()
    {
        $log = $this->logger->log('Just another log');
        $log = $this->logger->log('And another');
        $log = $this->logger->log('And another one');
        $recent = $this->logger->getRecentLogs(3);
        $this->assertObjectHasAttribute('items', $recent, 'Getting the recent logs failed');
    }
}