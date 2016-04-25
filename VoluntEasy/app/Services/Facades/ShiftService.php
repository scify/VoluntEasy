<?php namespace App\Services\Facades;

use \Illuminate\Support\Facades\Facade;

/**
 * Facade class to be called whenever the class UnitService is called
 */
class ShiftService extends Facade {

    /**
     * Get the registered name of the component. This tells $this->app what record to return
     * (e.g. $this->app[‘ShiftService’])
     *
     * @return string
     */
    protected static function getFacadeAccessor() {
    	return 'App\Services\ShiftService';
    }

}
