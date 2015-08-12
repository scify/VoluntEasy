<?php namespace App\Services;

use App\Models\Unit;
use App\Models\User;
use App\Models\Volunteer;
use App\Services\Facades\SearchService as Search;
use App\Services\Facades\UnitService as UnitServiceFacade;


class UserService {

    private $unitsIds = [];
    private $permittedUsers = [];

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
     * that are assigned to his/hers unit.
     * If the user is assigned to the root unit, return all volunteers.
     *
     * @return array
     */
    public function permittedVolunteers() {
        $permittedVolunteers = [];

        //user is admin/assigned to root
        //so return all volunters
        if (sizeof($this->isUserAdmin()) > 0) {
            $volunteers = Volunteer::all();
            foreach ($volunteers as $volunteer)
                array_push($permittedVolunteers, $volunteer);
        } else {
            //get the user's units with their immediate children (first level)
            //and their volunteers
            $user = User::with('units.volunteers')->findOrFail(\Auth::user()->id);

            foreach ($user->units as $unit) {
                foreach ($unit->volunteers as $volunteer)
                    array_push($permittedVolunteers, $volunteer);
            }

            //TODO: remove this?
            /*
            //loop through each unit and its children and add the volunteer ids to the array
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
            */
        }
        return $permittedVolunteers;
    }

    /**
     * Get only the ids of the permitted volunteers
     *
     * @return array
     */
    public function permittedVolunteersIds() {
        $volunteers = $this->permittedVolunteers();
        $permittedVolunteersIds = [];

        foreach ($volunteers as $volunteer)
            array_push($permittedVolunteersIds, $volunteer->id);

        return $permittedVolunteersIds;
    }


    /**
     * Get the users ids of the currently logged in user.
     * A user can view all the users but may only edit the users
     * that are directly beneath his/her unit.
     * If the user is assigned to the root unit, return all users.
     * Also all users should be able to assign unassigned users
     * (those that do not have any units)
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

            $userId = \Auth::user()->id;

            $user = User::where('id', $userId)->with('units.allChildren.users')->first();

            foreach ($user->units as $unit)
                $this->recursiveUsers($unit);

            $permittedUsers = $this->permittedUsers;
            //get the unassigned users
            $unassigned = User::whereDoesntHave('units')->get();
            foreach ($unassigned as $user)
                array_push($permittedUsers, $user);


        }
        return $permittedUsers;
    }


    /**
     * Recursively get the users of all the units
     *
     * @param $parent
     * @return mixed
     */
    public function recursiveUsers($parent) {

        foreach ($parent->users as $user)
            array_push($this->permittedUsers, $user);

        foreach ($parent->allChildren as $child) {

            foreach ($child->users as $user)
                array_push($this->permittedUsers, $user);

            if (sizeof($child->allChildren) > 0)
                $this->recursiveUsers($child);
        }

        return $parent;
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
     * Get the users that can be assigned to a unit.
     * Those are the users that:
     * [a]. are permitted to be edited by the user (see $this->permittedUsersIds())
     * [b]. are not assigned to any parent of the unit we are currently editing.
     *
     * @param $unitId
     * @return mixed
     */
    public function assignableUsersIds($unitId) {
        $permitted = $this->permittedUsersIds();

        $unit = Unit::with('allParents')->findOrFail($unitId);

        $parentIds = UnitServiceFacade::parentIds($unit);

        //the query
        $assignableUsers = User::whereDoesntHave('units', function ($q) use ($parentIds, $permitted) {
            $q->whereIn('id', $parentIds);
        })
            ->orWhereHas('units', function ($q) use ($unitId) {
                $q->where('id', $unitId);
            })
            ->whereIn('id', $permitted)
            ->get();

        return $assignableUsers;
    }


    public function prepareForDataTable($users) {
        $permittedUsers = UserService::permittedUsersIds();

        foreach ($users as $user) {
            if (in_array($user->id, $permittedUsers))
                $user->permitted = true;
            else
                $user->permitted = false;
        }

        return $users;
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

        $data = $this->prepareForDataTable($result);

        return ["data" => $data];
    }


}
