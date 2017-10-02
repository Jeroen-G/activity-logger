<?php

namespace JeroenG\LaravelPages\Tests;

use Carbon\Carbon;
use Orchestra\Testbench\TestCase;
use JeroenG\ActivityLogger\ActivityLogger;

/**
 * This is for testing the package.
 *
 * @author  JeroenG
 **/
class ActivityLoggerTest extends TestCase
{
    /**
     * The ActivityLogger instance.
     * @var object
     */
    protected $logger;

    /**
     * Setup before each test.
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        $this->artisan('migrate', ['--database' => 'testbench']);

        $this->logger = new ActivityLogger();
    }

    /**
     * Tell Testbench to use this package.
     * @param $app
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return ['JeroenG\ActivityLogger\ActivityLoggerServiceProvider'];
    }

    /**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        // Setup default database to use sqlite :memory:
        $app['config']->set('database.default', 'testbench');
        $app['config']->set('database.connections.testbench', [
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
        ]);
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
        $log = $this->logger->log('Hello ', ['greeting' => 'universe', 'awesomeness' => 9000]);
        $this->assertObjectHasAttribute('attributes', $log, 'Adding a log with context failed');
    }

    /**
     * Test adding a log with message, context and date.
     *
     * @test
     */
    public function testAddingLogWithContextAndDate()
    {
        $yesterday = Carbon::yesterday();
        $log = $this->logger->log('Hello ', ['greeting' => 'universe'], $yesterday);
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
        $tomorrow = Carbon::tomorrow();
        $yesterday = Carbon::yesterday();
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

    public function testDeletingAllLogs()
    {
        $log = $this->logger->log('Just another log');
        $log = $this->logger->log('And another');
        $log = $this->logger->log('And another one');
        $this->logger->deleteAll();
        $logs = $this->logger->getAllLogs();
        $this->assertObjectHasAttribute('items', $logs, 'Deleting all logs failed');
    }
}
