<?php namespace App\Http\Controllers;

class CronController extends Controller {

    private \App\Services\CronService $cronService;

    public function __construct(\App\Services\CronService $cronService) {
        $this->cronService = $cronService;
    }

    public function checkActions(){

        $expired = $this->cronService->expiredActions();
        $toExpire = $this->cronService->toExpireActions();
        $notAvailablle = $this->cronService->notAvailableVolunteers();

        return [
            'expired' => $expired,
            'toExpire' => $toExpire,
            'notAvailablle' => $notAvailablle,
        ];
    }

}

