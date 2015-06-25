<?php namespace App\Services;

use App\Models\Unit;
use App\Models\Volunteer;

class VolunteerService
{

    /**
     * This beauty, this classy and minimal piece of code that Laravel made for us,
     * fetches all the volunteers that do not belong to a unit.
     * Pls don't get teary-eyed.
     *
     * @return mixed
     */
    public function getNew()
    {
        $volunteers = Volunteer::doesntHave('units')->get();
        return $volunteers;
    }



}