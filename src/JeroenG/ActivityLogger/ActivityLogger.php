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
		Activity::create(array(
			'message' => $message,
			'context' => json_encode($context),
			'created_at' => $date
		));
	}
}