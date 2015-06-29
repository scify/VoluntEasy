<?php namespace App\Services;

use App\Models\Volunteer;
use App\Services\Facades\UnitService;

class VolunteerService
{

    /**
     * Get all the volunteers that are assigned to the root unit,
     * aka unassigned.
     *
     * @return mixed
     */
    public function getNew()
    {
        //get the root unit id
        $rootId = UnitService::getRoot()->first()->id;

        $volunteers = Volunteer::unassigned($rootId)->with('units.steps.status')->get();

        return $volunteers;
    }


}
