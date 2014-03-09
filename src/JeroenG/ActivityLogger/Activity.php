<?php namespace JeroenG\ActivityLogger;

/**
 * This is the activity model.
 *
 * @package ActivityLogger
 * @subpackage Models
 * @author 	JeroenG
 * 
 **/
class Activity extends \Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'activities';
	
	/**
	 * This fields may not be filled.
	 *
	 * @var array
	 */
	protected $guarded = array('id');

	/**
	 * Let Eloquent only use the created_at column.
	 *
	 * @return array
	 */
	public function getDates()
	{
	    return array('created_at');
	}

	/**
	 * Let Eloquent only use the created_at column.
	 *
	 * @return null
	 */
	public function setUpdatedAtAttribute($value)
	{
	    // Do nothing.
	}
}