<?php namespace App\Http\Controllers;

use App\Http\Requests\UnitRequest as UnitRequest;
use App\Models\Descriptions\VolunteerStatus;
use App\Models\Unit as Unit;
use App\Models\Volunteer;
use App\Services\Facades\NotificationService as NotificationService;
use App\Services\Facades\UnitService;
use App\Services\Facades\UserService;
use App\Services\Facades\VolunteerService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class UnitController extends Controller {
    public function __construct() {
        $this->middleware('auth');
        $this->middleware('permissions.unit', ['only' => ['edit']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        /* $units = Unit::orderBy('description', 'ASC')->with('parent')->get();
         //$units->setPath(\URL::to('/') . '/units');

         $userUnits = UserService::userUnits();
         */
        return view("main.units.list");
    }

    /**
     * Get the tree with its branches in JSON format
     *
     * @return mixed
     */
    public function tree($id) {
        $unit = Unit::where('id', $id)->with('allChildren')->first();

        return $unit;
    }

    /**
     * Show the form for creating a new resource.
     * Roots and branches have a different layout, so we use
     * different routes and templates for them.
     *
     * @return Response
     */
    public function create() {
        $root = UnitService::getRoot();

        $users = UserService::permittedUsers();

        if (count($root) == 0) {
            $type = 'root';
            return view("main.units.create_root", compact('type', 'users'));
        } else {
            // $tree = Unit::whereNull('parent_unit_id')->with('allChildren')->first();
            $type = 'branch';

            return view("main.units.create_branch", compact('type', 'users'));
            // return view("main.units.create_branch", compact('type', 'tree', 'userUnits'));
        }
    }

    /**
     * Store a newly created resource in storage.
     * Also assign the predefined steps and
     * the users, if they are set.
     *
     * @param UnitRequest $request
     * @return Response
     */
    public function store(UnitRequest $request) {
        $unit = Unit::create($request->all());

        $users = [];

        //get the selected users from the select2 array
        //and add them to an array
        if(\Input::has('usersSelect')) {
            foreach (\Input::get('usersSelect') as $user) {
                array_push($users, $user);
            }

            //sync the selected users
            $unit->users()->sync($users);

            //notify them
            NotificationService::usersToUnit($users, $unit);
        }

        //create the steps for each unit
        $unit->steps()->saveMany(UnitService::createSteps());

        return Redirect::route('unit/one', ['id' => $unit->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id) {
        $active = Unit::with('actions', 'allActions', 'volunteers')->findOrFail($id);
        $actives = [];
        array_push($actives, $active->id);

        $type = UnitService::type($active);

        $userUnits = UserService::userUnits();

        $branch = UnitService::getBranchString($active);

        $unitId = $active->id;
        $parentUnitId = $active->parent_unit_id;
        $pendingStatus = VolunteerStatus::pending();

        //get all volunteers to show in select box
        //those should be the volunteers that belong to the parent unit
        //or to the same unit
        //of the unit we are viewing and their status is not pending
        //and do not have the current unit marked as excluded
        $allVolunteers = Volunteer::whereHas('units', function ($query) use ($unitId, $parentUnitId, $pendingStatus) {
            $query->where('unit_id', $unitId)
                ->orWhere('unit_id', $parentUnitId)
                ->where('volunteer_status_id', '<>', $pendingStatus);
        })->whereHas("unitsExcludes", function ($q) use ($unitId) {
            $q->where('unit_id', $unitId);
        }, '<', 1)->orderBy('name', 'asc')->get();


        //get the volunteers that are assigned to current unit
        //and their statuses
        $unitId = $active->id;
        $volunteers = [];
        foreach ($active->volunteers as $volunteer) {
            $volunteerId = $volunteer->id;
            $vol = Volunteer::with(['units' => function ($query) use ($unitId, $volunteerId) {
                $query->where('unit_id', $unitId)->with(['steps.statuses' => function ($query) use ($volunteerId) {
                    $query->where('volunteer_id', $volunteerId)->with('status');
                }]);
            }])->findOrFail($volunteer->id);

            $vol = VolunteerService::setStatusToUnits($vol);
            array_push($volunteers, $vol);
        }

        return view("main.units.show", compact('active', 'actives', 'type', 'allVolunteers', 'volunteers', 'userUnits', 'branch'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id) {
        $active = Unit::where('id', $id)->with('users', 'actions')->first();

        //display all the users in the front end
        $users = UserService::assignableUsersIds($id);

        $userIds = UserService::userIds($active->users);

        $type = UnitService::type($active);

        return view("main.units.edit", compact('active', 'type', 'users', 'userIds'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UnitRequest $request
     * @return Response
     */
    public function update(UnitRequest $request) {
        $unit = Unit::with('users')->findOrFail($request->get('id'));

        $users = [];
        $newUsers = [];

        //get the selected users from the select2 array
        //and add them to an array
        if(\Input::has('usersSelect')) {
            foreach (\Input::get('usersSelect') as $user) {
                //get the new users' ids to notify them
                if (!in_array($user, $unit->users->lists('id')))
                    array_push($newUsers, $user);

                //keep the users in a list
                array_push($users, $user);
            }
        }

        //sync the selected users
        $unit->users()->sync($users);

        //notify only new users
        NotificationService::usersToUnit($newUsers, $unit);

        //update the unit
        $unit->update($request->all());

        return Redirect::route('unit/one', ['id' => $unit->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id) {
        $unit = Unit::with('allActions', 'allChildren', 'users', 'volunteers')->findOrFail($id);

        //if the unit has actions, do not delete
        if (sizeof($unit->actions) > 0) {
            Session::flash('flash_message', 'Η οργανωτική μονάδα περιέχει δράσεις και δεν μπορεί να διαγραφεί.');
            Session::flash('flash_type', 'alert-danger');

            return;
            //return Redirect::to('units');
        }
        //if the unit has children units, do not delete
        if (sizeof($unit->allChildren) > 0) {
            Session::flash('flash_message', 'Η οργανωτική μονάδα δεν μπορεί να διαγραφεί γιατί εξαρτώνται άλλες μονάδες από αυτή.');
            Session::flash('flash_type', 'alert-danger');

            return;
            //return Redirect::back();
        }
        //if the unit has volunteers, do not delete
        if (sizeof($unit->volunteers) > 0) {
            Session::flash('flash_message', 'Η οργανωτική μονάδα περιέχει εθελοντές και δεν μπορεί να διαγραφεί.');
            Session::flash('flash_type', 'alert-danger');

            return;
            //return Redirect::back();
        }
        //if the unit has users, do not delete
        if (sizeof($unit->users) > 0) {
            Session::flash('flash_message', 'Η οργανωτική μονάδα περιέχει χρήστες και δεν μπορεί να διαγραφεί.');
            Session::flash('flash_type', 'alert-danger');

            return;
            //return Redirect::back();
        }

        $unit->steps()->delete();
        $unit->delete();

        Session::flash('flash_message', 'Η οργανωτική μονάδα διαγράφηκε.');
        Session::flash('flash_type', 'alert-success');


        return;
    }

    /**
     * Search all units
     *
     * @return mixed
     */
    public function search() {
        $units = UnitService::search();

        return $units;
    }

    public function rootUnit() {
        return view('auth/rootUnit');
    }


    /**
     * Sync the users with the db.
     *
     * @param Request $request
     * @return mixed
     */
    public function addUsers(Request $request) {
        $unit = Unit::findOrFail($request->get('id'));

        $unit->users()->sync($request->get('users'));

        //notify users
        NotificationService::usersToUnit($request->get('users'), $unit);

        return $unit->id;
    }

    /**
     * Sync the unit volunteers with the db.
     * Also add an entry to the unit history table
     *
     * @param Request $request
     * @return mixed
     */
    public function addVolunteers(Request $request) {
        $unit = Unit::findOrFail($request->get('id'));

        $unit->volunteers()->detach();

        if($request->has('volunteers')) {
            // create a history entry for each new volunteer
            foreach ($request->get('volunteers') as $volunteer) {
                VolunteerService::addToUnit($unit->id, $unit->parent_unit_id, $volunteer);
            }
        }
        return $unit->id;
    }


    public function wholeTree() {
        $tree = UnitService::getTree();
        $userUnits = UserService::userUnits();
        return view("main.tree.tree", compact('tree', 'userUnits'));
    }
}
