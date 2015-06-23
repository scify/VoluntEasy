<?php namespace App\Services;

use App\Models\User;


class UserService
{


    public function userUnitsIds(User $user)
    {
        $active = array();
        foreach ($user->units as $unit) {
            array_push($active, $unit->id);
        }

        return $active;
    }


}