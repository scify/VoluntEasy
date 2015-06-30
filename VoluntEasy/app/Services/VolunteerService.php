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

        $volunteers = Volunteer::unit($rootId)->with('units.steps.status')->get();

        return $volunteers;
    }


    /**
     * From a list of volunteers, get a list of ids.
     *
     * @param $volunteers
     * @return mixed
     */
    public function volunteerIds($volunteers)
    {
        $ids = [];

        foreach ($volunteers as $volunteer)
            array_push($ids, $volunteer->id);

        return $ids;
    }

}
