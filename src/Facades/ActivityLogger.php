<?php

namespace JeroenG\ActivityLogger\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * This registers the facade for the package.
 *
 * Place the line below in the aliases array inside app/config/app.php
 * <code>'Activity'	  => 'JeroenG\ActivityLogger\Facades\ActivityLogger',</code>
 * 'Activity' is then the facade you can use in your code. If you want it to be something else,you can change this here.
 *
 * @author 	JeroenG
 **/
class ActivityLogger extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'activitylogger';
    }
}
