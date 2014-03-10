<?php namespace JeroenG\ActivityLogger;

use JeroenG\ActivityLogger\ActivityLogger;

/**
 * This is for testing the package
 *
 * @package ActivityLogger
 * @subpackage Tests
 * @author 	JeroenG
 * 
 **/
class LaravelAuthTest extends \Orchestra\Testbench\TestCase
{
	/**
     * Get package providers.
     * 
     * At a minimum this is the package being tested, but also
     * would include packages upon which our package depends, e.g. Cartalyst/Sentry
     * In a normal app environment these would be added to the 'providers' array in
     * the config/app.php file.
     *
     * @return array
     */
	protected function getPackageProviders()
	{
	    return array('JeroenG\ActivityLogger\ActivityLoggerServiceProvider');
	}

    /**
     * Get package aliases.
     * 
     * In a normal app environment these would be added to
     * the 'aliases' array in the config/app.php file.  If your package exposes an
     * aliased facade, you should add the alias here, along with aliases for
     * facades upon which your package depends, e.g. Cartalyst/Sentry
     *
     * @return array
     */
	protected function getPackageAliases()
	{
	    return array(
	        'Activity' => 'JeroenG\ActivityLogger\Facades\ActivityLogger',
	    );
	}

	/**
     * Define environment setup.
     *
     * @param  Illuminate\Foundation\Application    $app
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        // reset base path to point to our package's src directory
        $app['path.base'] = __DIR__ . '/../src';

        $app['config']->set('database.default', 'testbench');
        $app['config']->set('database.connections.testbench', array(
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
        ));
    }

	/**
     * Setup the test environment.
     *
     * @return void
     */
	public function setUp()
	{
		parent::setUp();

		$artisan = $this->app->make('artisan');
		$artisan->call('migrate', array(
            '--database' => 'testbench',
            '--path'     => 'migrations',
        ));

        \DB::table('activities')->insert(array(
            'message'    	=>	'Hello World!',
            'context'  		=>	json_encode(array('foo' => 'bar')),
            'created_at'	=>	\Carbon\Carbon::now(),
        ));
	}

	/**
     * Test adding a log with only a message.
     *
     * @test
     */
	public function testAddingSimpleLog()
	{
		$log = \Activity::log('Hello Universe');
		$this->assertObjectHasAttribute('attributes', $log, 'Adding a simple log failed');
	}

	/**
     * Test adding a log with message and context.
     *
     * @test
     */
	public function testAddingLogWithContext()
	{
		$log = \Activity::log('Hello ', array('greeting' => 'universe', 'awesomeness' => 9000));
		$this->assertObjectHasAttribute('attributes', $log, 'Adding a log with context failed');
	}

	/**
     * Test adding a log with message, context and date.
     *
     * @test
     */
	public function testAddingLogWithContextAndDate()
	{
		$yesterday = \Carbon\Carbon::yesterday();
		$log = \Activity::log('Hello ', array('greeting' => 'universe'), $yesterday);
		$this->assertObjectHasAttribute('attributes', $log, 'Adding a log with context and date failed');
	}

	/**
     * Test getting all logs.
     *
     * @test
     */
	public function testGettingAllLogs()
	{
		$logs = \Activity::getAllLogs();
		$this->assertObjectHasAttribute('items', $logs, 'Getting all logs failed');
	}

	/**
     * Test getting a single log.
     *
     * @test
     */
	public function testGettingSingleLog()
	{
		$log = \Activity::getLog(1);
		$this->assertNotNull($log);
	}

	/**
     * Test getting all logs created between yesterday and tomorrow.
     *
     * @test
     */
	public function testGettingLogsInTimespan()
	{
		$tomorrow = \Carbon\Carbon::tomorrow();
		$yesterday = \Carbon\Carbon::yesterday();

		$logs = \Activity::getLogsBetween($yesterday, $tomorrow);
		$this->assertNotNull($logs);
	}

    /**
     * Test getting the most recent logs.
     *
     * @test
     */
    public function testGettingRecentLogs()
    {
        $log = \Activity::log('Just another log');
        $log = \Activity::log('And another');
        $log = \Activity::log('And another one');

        $recent = \Activity::getRecentLogs(3);
        $this->assertObjectHasAttribute('items', $recent, 'Getting the recent logs failed');
    }
}