<?php namespace JeroenG\ActivityLogger;

use JeroenG\ActivityLogger\Activity;

/**
 * This class is the core of the package. Everything is handles through here,
 * although you might always use the Facade 'Activity'.
 *
 * @package ActivityLogger
 * @author 	JeroenG
 * 
 **/
class ActivityLogger {


	/**
	 * Log an activity
	 *
	 * @param string $message A basic message 
	 * @param array $context Any additional data you might want to save.
	 * @param timestamp $date Timestamp of when it's happened. If none is passed the current timestamp will be used.
	 * @return void
	 */
	public function log($message, $context = array(), $date = null)
	{
		if(is_null($date)) {
			$date = new \DateTime;
		}
		return Activity::create(array(
			'message' => $message,
			'context' => $context,
			'created_at' => $date
		));
	}

	/**
	 * Get all data from one log entry.
	 *
	 * @param int $id The id of the log.
	 * @return object
	 */
	public function getLog($id)
	{
		return Activity::find($id);
	}

	/**
	 * Get all data from all logs.
	 *
	 * @return object
	 */
	public function getAllLogs()
	{
		return Activity::all();
	}

	/**
	 * Get all logs created within a given timespan.
	 *
	 * @param timestamp $start Every log created after this date.
	 * @param timestamp $end Every log created before this date.
	 * @return array
	 */
	public function getLogsBetween($start, $end)
	{
		return Activity::whereBetween('created_at', array($start, $end))->get();
	}
}