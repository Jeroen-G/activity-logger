<?php

namespace JeroenG\ActivityLogger;

use Illuminate\Database\Eloquent\Model;

/**
 * This is the activity model.
 *
 * @author 	JeroenG
 **/
class Activity extends Model
{
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
    protected $guarded = ['id'];

    /**
     * Let Eloquent only use the created_at column.
     *
     * @return array
     */
    public function getDates()
    {
        return ['created_at'];
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

    /**
     * Delete all logs (not way back!).
     * @return void
     */
    public static function deleteAll()
    {
        return \DB::table('activities')->delete();
    }
}
