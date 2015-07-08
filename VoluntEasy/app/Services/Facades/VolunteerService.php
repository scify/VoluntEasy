<?php namespace App\Services\Facades;

use \Illuminate\Support\Facades\Facade;

/**
 * Facade class to be called whenever the class VolunteerService is called
 */
class VolunteerService extends Facade {

    /**
     * Get the registered name of the component. This tells $this->app what record to return
     * (e.g. $this->app[‘userService’])
     *
     * @return string
     */
    protected static function getFacadeAccessor() { 
    	return 'App\Services\VolunteerService'; 
    }

}
