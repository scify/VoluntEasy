<?php namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;


class UserService
{

    public function userUnits(){
        return $this->userUnitsIds(Auth::user());
    }

    public function userUnitsIds(User $user)
    {
        $userUnits = array();
        foreach ($user->units as $unit) {
            array_push($userUnits, $unit->id);
        }

        return $userUnits;
    }


}
