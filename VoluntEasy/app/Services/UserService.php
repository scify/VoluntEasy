<?php namespace App\Services;

use App\Models\User;
use App\Services\Facades\UnitService as UnitServiceFacade;


class UserService {

    public $unitsIds = array();

    /**
     * Get the unit ids of the currently logged in user
     *
     * @return array
     */
    public function userUnits() {
        return $this->userUnitsIds(\Auth::user());
    }

    /**
     * Get the unit ids according to user
     *
     * @param User $user
     * @return array
     */
    public function userUnitsIds(User $user) {
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
    public function withChildren($units) {
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
    public function userIds($users) {
        $ids = array();
        foreach ($users as $user) {
            array_push($ids, $user->id);
        }

        return $ids;
    }

    /**
     * Check if the logged in user is assigned to root unit.
     *
     * @return mixed
     */
    public function isUserAdmin(){
        $root = UnitServiceFacade::getRoot();

        $users = User::unit($root->id)->where('id', \Auth::user()->id)->get();

        return $users;
    }


    /**
     * Get the users ids of the currently logged in user.
     * A user can view all the users but may only edit the users
     * that are directly beneath his/her unit.
     * If the user is assigned to the root unit, return all users.
     *
     * @return array
     */
    public function permittedUsers() {
        $permittedUsers = [];

        //user is admin/assigned to root
        if (sizeof($this->isUserAdmin()) > 0) {
            $users = User::all();
            foreach ($users as $user)
                array_push($permittedUsers, $user);
        } else {
            //get the user's units with their immediate children (first level)
            //and their users
            $user = User::where('id', \Auth::user()->id)->with('units.children.users')->first();

            //loop through each unit and its children and add the user ids to the array
            foreach ($user->units as $unit) {
                if (sizeof($unit->children) > 0) {
                    foreach ($unit->children as $child) {
                        if (sizeof($child->users) > 0) {
                            foreach ($child->users as $user) {
                                if (!in_array($user, $permittedUsers))
                                    array_push($permittedUsers, $user);
                            }
                        }
                    }
                }
                if (sizeof($unit->users) > 0) {
                    foreach ($unit->users as $user) {
                        if (!in_array($user, $permittedUsers))
                            array_push($permittedUsers, $user);
                    }
                }
            }
        }
        return $permittedUsers;
    }

    /**
     * Get only the ids of the permitted users
     *
     * @return array
     */
    public function permittedUsersIds() {
        $users = $this->permittedUsers();
        $permittedUsersIds = [];

        foreach ($users as $user)
            array_push($permittedUsersIds, $user->id);

        return $permittedUsersIds;
    }
}
