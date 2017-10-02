<?php

namespace JeroenG\ActivityLogger;

/**
 * This class is the core of the package. Everything is handles through here,
 * although you might always use the Facade 'Activity'.
 *
 * @author 	JeroenG
 **/
class ActivityLogger
{
    /**
     * Log an activity.
     *
     * @param string $message A basic message
     * @param array $context Any additional data you might want to save.
     * @param timestamp $date Timestamp of when it's happened. If none is passed the current timestamp will be used.
     * @return void
     */
    public function log($message, $context = [], $date = null)
    {
        if (is_null($date)) {
            $date = new \DateTime;
        }

        return Activity::create([
            'message' => $message,
            'context' => $context,
            'created_at' => $date,
        ]);
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
        return Activity::orderBy('created_at', 'desc')->get();
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
        return Activity::whereBetween('created_at', [$start, $end])->orderBy('created_at', 'desc')->get();
    }

    /**
     * Get the most recent logs.
     *
     * @param int $number (optional) The number of logs to retrieve, default is 5.
     * @return object
     */
    public function getRecentLogs($number = 5)
    {
        return Activity::take($number)->orderBy('created_at', 'desc')->get();
    }

    /**
     * Delete all logs (not way back!).
     * @return void
     */
    public function deleteAll()
    {
        return Activity::deleteAll();
    }
}
