<?php namespace App\Http\Controllers;


use App\Services\Facades\CronService;

class CronController extends Controller {


    public function checkActions(){

        $expired = CronService::expiredActions();
        $toExpire = CronService::toExpireActions();
        $notAvailablle = CronService::notAvailableVolunteers();

        return [
            'expired' => $expired,
            'toExpire' => $toExpire,
            'notAvailablle' => $notAvailablle,
        ];
    }


}

