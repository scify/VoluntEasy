<?php namespace App\Services;

use App\Models\Unit;
use App\Models\User;
use App\Models\Volunteer;
use App\Services\Facades\UnitService as UnitServiceFacade;
use App\Services\Facades\SearchService as Search;


class UserService {

    public $unitsIds = array();

    /**
     * This array holds the names of the filters that the user is able to search by.
     * Filters correspond to column names.
     * If a filter doesn't have an operator, a special action is required.
     *
     * @var array
     */
    private $filters = [
        'name' => 'like%',
        'email' => '=',
        'unit_id' => '',
    ];


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
    public function isUserAdmin() {
        $root = UnitServiceFacade::getRoot();

        $users = User::unit($root->id)->where('id', \Auth::user()->id)->get();

        return $users;
    }


    /**
     *  Get an array of the permitted units
     *  for each user
     *
     * @return array
     */
    public function permittedUnits() {

        if (sizeof($this->isUserAdmin()) > 0) {
            $units = Unit::all();

            $this->withChildren($units);

            return $this->unitsIds;

        } else {
            $user = User::with('units.allChildren')->findOrFail(\Auth::user()->id);

            $this->withChildren($user->units);

            return $this->unitsIds;
        }
    }


    /**
     * Get the volunteers ids of the currently logged in user.
     * A user can view all the volunteers but may only edit the volunteers
     * that are directly beneath his/her unit.
     * If the user is assigned to the root unit, return all volunteers.
     *
     * @return array
     */
    public function permittedVolunteers() {
        $permittedVolunteers = [];

        //user is admin/assigned to root
        if (sizeof($this->isUserAdmin()) > 0) {
            $volunteers = Volunteer::all();
            foreach ($volunteers as $volunteer)
                array_push($permittedVolunteers, $volunteer);
        } else {
            //get the user's units with their immediate children (first level)
            //and their volunteers
            $user = User::where('id', \Auth::user()->id)->with('units.children.volunteers')->first();

            //loop through each unit and its children and add the user ids to the array
            foreach ($user->units as $unit) {
                if (sizeof($unit->children) > 0) {
                    foreach ($unit->children as $child) {
                        if (sizeof($child->volunteers) > 0) {
                            foreach ($child->volunteers as $volunteer) {
                                if (!in_array($volunteer, $permittedVolunteers))
                                    array_push($permittedVolunteers, $volunteer);
                            }
                        }
                    }
                }
                if (sizeof($unit->volunteers) > 0) {
                    foreach ($unit->volunteers as $volunteer) {
                        if (!in_array($user, $permittedVolunteers))
                            array_push($permittedVolunteers, $volunteer);
                    }
                }
            }
        }
        return $permittedVolunteers;
    }

    /**
     * Get only the ids of the permitted volunteers
     *
     * @return array
     */
    public function permittedVolunteersIds() {
        $users = $this->permittedVolunteers();
        $permittedUsersIds = [];

        foreach ($users as $user)
            array_push($permittedUsersIds, $user->id);

        return $permittedUsersIds;
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

    /**
     * Dynamic search chains a lot of queries depending on the filters sent by the user.
     *
     * @return mixed
     */
    public function search() {

        $query = User::select();

        foreach ($this->filters as $column => $filter) {
            if (\Input::has($column)) {
                $value = \Input::get($column);
                switch ($filter) {
                    case '=':
                        if (!Search::notDropDown($value, $column))
                            $query->where($column, '=', $value);
                        break;
                    case 'like%':
                        $query->where($column, 'like', $value . '%');
                        break;
                    case '':
                        switch ($column) {
                            case 'unit_id':
                                if (!Search::notDropDown($value, $column)) {
                                    $id = \Input::get('unit_id');
                                    $query->whereHas('units', function ($query) use ($id) {
                                        $query->where('id', $id);
                                    });
                                }
                                break;

                        }
                    default:
                        break;
                }
            }
        }

        $result = $query->orderBy('name', 'ASC')->with('units')->get();
        //$result->setPath(\URL::to('/') . '/units');
        return $result;
    }


}
