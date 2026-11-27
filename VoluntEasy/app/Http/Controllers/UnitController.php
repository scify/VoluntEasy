<?php

namespace App\Http\Controllers;

use App\Http\Requests\UnitRequest;
use App\Models\Descriptions\VolunteerStatus;
use App\Models\Unit;
use App\Models\Volunteer;
use App\Services\NotificationService;
use App\Services\UnitService;
use App\Services\UserService;
use App\Services\Volunteers\VolunteerAssignment;
use App\Services\VolunteerService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class UnitController extends Controller
{
    private NotificationService $notificationService;

    private UnitService $unitService;

    private UserService $userService;

    private VolunteerService $volunteerService;

    private VolunteerAssignment $volunteerAssignment;

    public function __construct(VolunteerAssignment $volunteerAssignment, NotificationService $notificationService, UnitService $unitService, UserService $userService, VolunteerService $volunteerService)
    {
        $this->notificationService = $notificationService;
        $this->unitService = $unitService;
        $this->userService = $userService;
        $this->volunteerService = $volunteerService;
        $this->volunteerAssignment = $volunteerAssignment;
        $this->middleware('auth');
        $this->middleware('permissions.unit', ['only' => ['edit']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('main.units.list');
    }

    /**
     * Get the tree with its branches in JSON format
     *
     * @return mixed
     */
    public function tree($id)
    {
        $unit = Unit::where('id', $id)->with('allChildren')->first();

        return $unit;
    }

    /**
     * Show the form for creating a new resource.
     * Roots and branches have a different layout, so we use
     * different routes and templates for them.
     */
    public function create()
    {
        $root = $this->unitService->getRoot();

        $users = $this->userService->permittedUsers();

        if ($root == null) {
            $type = 'root';

            return view('main.units.create_root', compact('type', 'users'));
        } else {
            // $tree = Unit::whereNull('parent_unit_id')->with('allChildren')->first();
            $type = 'branch';

            return view('main.units.create_branch', compact('type', 'users'));
            // return view("main.units.create_branch", compact('type', 'tree', 'userUnits'));
        }
    }

    /**
     * Store a newly created resource in storage.
     * Also assign the predefined steps and
     * the users, if they are set.
     */
    public function store(UnitRequest $request)
    {
        $unit = Unit::create($request->all());

        $users = [];

        // get the selected users from the select2 array
        // and add them to an array
        if (\Request::filled('usersSelect')) {
            foreach (\Request::get('usersSelect') as $user) {
                array_push($users, $user);
            }
            // sync the selected users
            $unit->users()->sync($users);

            // notify them
            $this->notificationService->usersToUnit($users, $unit);
        }

        // create the steps for each unit
        $unit->steps()->saveMany($this->unitService->createSteps());

        return Redirect::route('unit/one', ['id' => $unit->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     */
    public function show($id)
    {
        $active = Unit::with('actions', 'allActions', 'volunteers')->findOrFail($id);

        $type = $this->unitService->type($active);

        $userUnits = $this->userService->userUnits();

        $branch = $this->unitService->getBranchString($active);

        $unitId = $active->id;
        $parentUnitId = $active->parent_unit_id;
        $pendingStatus = VolunteerStatus::pending();

        // get all volunteers to show in select box
        // those should be the volunteers that belong to the parent unit
        // or to the same unit
        // of the unit we are viewing and their status is not pending
        // and do not have the current unit marked as excluded
        $allVolunteers = Volunteer::whereHas('units', function ($query) use ($unitId, $parentUnitId, $pendingStatus) {
            $query->where('unit_id', $unitId)
                ->orWhere('unit_id', $parentUnitId)
                ->where('volunteer_status_id', '<>', $pendingStatus);
        })->whereHas('unitsExcludes', function ($q) use ($unitId) {
            $q->where('unit_id', $unitId);
        }, '<', 1)->orderBy('name', 'asc')->get();

        // get the volunteers that are assigned to current unit
        // and their statuses
        $unitId = $active->id;
        $volunteers = [];
        foreach ($active->volunteers as $volunteer) {
            $volunteerId = $volunteer->id;
            $vol = Volunteer::with(['units' => function ($query) use ($unitId, $volunteerId) {
                $query->where('unit_id', $unitId)->with(['steps.statuses' => function ($query) use ($volunteerId) {
                    $query->where('volunteer_id', $volunteerId)->with('status');
                }]);
            }])->findOrFail($volunteer->id);

            $vol = $this->volunteerService->setStatusToUnits($vol);
            array_push($volunteers, $vol);
        }

        return view('main.units.show', compact('active', 'type', 'allVolunteers', 'volunteers', 'userUnits', 'branch'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     */
    public function edit($id)
    {
        $active = Unit::where('id', $id)->with('users', 'actions')->first();

        // display all the users in the front end
        $users = $this->userService->assignableUsersIds($id);

        $userIds = $this->userService->userIds($active->users);

        $type = $this->unitService->type($active);

        return view('main.units.edit', compact('active', 'type', 'users', 'userIds'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UnitRequest $request)
    {
        $unit = Unit::with('users')->findOrFail($request->get('id'));

        $users = [];
        $newUsers = [];

        // get the selected users from the select2 array
        // and add them to an array
        if (\Request::filled('usersSelect')) {
            foreach (\Request::get('usersSelect') as $user) {
                // get the new users' ids to notify them
                if (! in_array($user, $unit->users->pluck('id')->all())) {
                    array_push($newUsers, $user);
                }

                // keep the users in a list
                array_push($users, $user);
            }
        }

        // sync the selected users
        $unit->users()->sync($users);

        // notify only new users
        $this->notificationService->usersToUnit($newUsers, $unit);

        // update the unit
        $unit->update($request->all());

        return Redirect::route('unit/one', ['id' => $unit->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     */
    public function destroy($id)
    {
        $unit = Unit::with('allActions', 'allChildren', 'users', 'volunteers')->findOrFail($id);

        // if the unit has actions, do not delete
        if (count($unit->allActions) > 0) {
            Session::flash('flash_message', trans('entities/units.hasActions'));
            Session::flash('flash_type', 'alert-danger');

            return;
            // return Redirect::to('units');
        }
        // if the unit has children units, do not delete
        if (count($unit->allChildren) > 0) {
            Session::flash('flash_message', trans('entities/units.isParent'));
            Session::flash('flash_type', 'alert-danger');

            return;
            // return Redirect::back();
        }
        // if the unit has volunteers, do not delete
        if (count($unit->volunteers) > 0) {
            Session::flash('flash_message', trans('entities/units.hasVolunteers'));
            Session::flash('flash_type', 'alert-danger');

            return;
            // return Redirect::back();
        }
        // if the unit has users, do not delete
        if (count($unit->users) > 0) {
            Session::flash('flash_message', trans('entities/units.hasUsers'));
            Session::flash('flash_type', 'alert-danger');

            return;
            // return Redirect::back();
        }

        $unit->steps()->delete();
        $unit->delete();

        Session::flash('flash_message', trans('entities/units.deleted'));
        Session::flash('flash_type', 'alert-success');

    }

    /**
     * Search all units
     *
     * @return mixed
     */
    public function search()
    {
        $units = $this->unitService->search();

        return $units;
    }

    /**
     * Sync the users with the db.
     *
     * @return mixed
     */
    public function addUsers(Request $request)
    {
        $unit = Unit::findOrFail($request->get('id'));

        $unit->users()->sync($request->get('users'));

        // notify users
        $this->notificationService->usersToUnit($request->get('users'), $unit);

        return $unit->id;
    }

    /**
     * Sync the unit volunteers with the db.
     * Also add an entry to the unit history table
     *
     * @return mixed
     */
    public function addVolunteers(Request $request)
    {
        $unit = Unit::findOrFail($request->get('id'));

        $unit->volunteers()->detach();

        if ($request->has('volunteers')) {
            // create a history entry for each new volunteer
            foreach ($request->get('volunteers') as $volunteer) {
                $this->volunteerAssignment->addToUnit($unit->id, $unit->parent_unit_id, $volunteer);
            }
        }

        return $unit->id;
    }

    public function wholeTree()
    {
        $tree = $this->unitService->getTree();
        $userUnits = $this->userService->userUnits();

        return view('main.tree.tree', compact('tree', 'userUnits'));
    }
}
