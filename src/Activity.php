<?php namespace JeroenG\ActivityLogger;

use Illuminate\Database\Eloquent\Model;

/**
 * This is the activity model.
 *
 * @package ActivityLogger
 * @subpackage Models
 * @author 	JeroenG
 * 
 **/
class Activity extends Model {

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

	/**
	 * Encode the context array into json.
	 *
	 * @return array
	 */
	public function setContextAttribute($value)
	{
		$this->attributes['context'] = json_encode($value);
	}

	/**
	 * Decode the context into an array.
	 *
	 * @return array
	 */
	public function getContextAttribute($value)
	{
		return json_decode($value);
	}
}