<?php

namespace App\Http\Controllers;

use App\Services\CronService;

class CronController extends Controller
{
    private CronService $cronService;

    public function __construct(CronService $cronService)
    {
        $this->cronService = $cronService;
    }

    public function checkActions()
    {

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
