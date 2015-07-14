<?php namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;


class UserService
{

    public $unitsIds = array();


    /**
     * Get the unit ids of the currently logged in user
     *
     * @return array
     */
    public function userUnits()
    {
        return $this->userUnitsIds(Auth::user());
    }

    /**
     * Get the unit ids according to user
     *
     * @param User $user
     * @return array
     */
    public function userUnitsIds(User $user)
    {
        $user->units->load('allChildren');

        $this->withChildren($user->units);

        return $this->unitsIds;
    }


    /**
     * Recursively get the ids of all children units
     *
     * @param $units
     * @return array
     */
    public function withChildren($units)
    {
        foreach ($units as $unit) {
            if (sizeof($unit->allChildren) > 0) {
                $this->unitsIds[] = $unit->id;
                $this->withChildren($unit->allChildren);
            } else {
                $this->unitsIds[] = $unit->id;
            }
        }
    }

    /**
     * Create an array that includes only the user ids
     * of the users assigned to a unit.
     * Used in the front end, in order to display the currently assigned users.
     *
     * @param $users
     * @return array
     */
    public function userIds($users)
    {
        $ids = array();
        foreach ($users as $user) {
            array_push($ids, $user->id);
        }

        return $ids;
    }
}
