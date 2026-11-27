<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\Action;
use App\Models\Roles\Role;
use App\Models\Unit;
use App\Models\User;
use App\Services\NotificationService;
use App\Services\UnitService;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    private NotificationService $notificationService;

    private UnitService $unitService;

    private UserService $userService;

    public function __construct(NotificationService $notificationService, UnitService $unitService, UserService $userService)
    {
        $this->notificationService = $notificationService;
        $this->unitService = $unitService;
        $this->userService = $userService;
        $this->middleware('auth');
        $this->middleware('permissions.user', ['only' => ['edit']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('main.users.list');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $roles = Role::all(['name', 'id']);
        $units = Unit::whereNotNull('parent_unit_id')->get(['description', 'id']);
        $actions = Action::all(['description', 'id', 'unit_id']);
        $permittedUnits = $this->userService->permittedUnits();

        return view('main.users.create', compact('roles', 'units', 'permittedUnits', 'actions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {
        $request['password'] = \Hash::make($request['password']);
        $user = User::create($request->all());

        // store the user image
        if (\Request::file('image') != null) {
            $user->update(['image_name' => $this->userService->storeImage(\Request::file('image'), $user->email)]);
        }

        // refresh user roles
        $user->refreshRoles(\Request::get('roles'));

        return Redirect::route('user/profile', ['id' => $user->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     */
    public function show($id)
    {
        $user = User::where('id', $id)->with('units', 'roles')->first();

        $isAdmin = $this->userService->isAdmin($id);

        $tree = $this->unitService->getTree();

        $permittedUsers = $this->userService->permittedUsersIds();

        return view('main.users.show', compact('user', 'tree', 'permittedUsers', 'isAdmin'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     */
    public function edit($id)
    {

        $roles = Role::all(['name', 'id']);
        // get all units except for the root unit
        $units = Unit::whereNotNull('parent_unit_id')->get(['description', 'id']);
        $actions = Action::all(['description', 'id', 'unit_id']);
        $permittedUnits = $this->userService->permittedUnits();

        $user = User::where('id', $id)->first();

        return view('main.users.edit', compact('user', 'roles', 'units', 'actions', 'permittedUnits'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $request)
    {

        $user = User::findOrFail($request->get('id'));

        if ($request['password'] != null && $request['password'] != '') {
            $request['password'] = \Hash::make($request['password']);
            $user->update($request->all());
        } else {
            $user->update([
                'name' => $request['name'],
                'last_name' => $request['last_name'],
                'email' => $request['email'],
                'addr' => $request['addr'],
                'tel' => $request['tel'],
            ]);
        }

        // refresh user roles
        $user->refreshRoles(\Request::get('roles'));

        // store the user image
        if (\Request::file('image') != null) {
            $user->update(['image_name' => $this->userService->storeImage(\Request::file('image'), $user->email)]);
        }

        return Redirect::route('user/profile', ['id' => $user->id]);
    }

    /**
     * Assign user to multiple units
     *
     * @return mixed
     */
    public function addUnits(Request $request)
    {
        $user = User::findOrFail($request->get('id'));

        if ($request->get('units') == null) {
            $user->units()->detach();
        } else {
            $user->units()->sync($request->get('units'));
        }

        // notify user that they 're added to unit
        foreach ($request->get('units') as $unitId) {
            $unit = Unit::find($unitId);
            $this->notificationService->userToUnit($user->id, $unit);
        }

        return $user->id;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     */
    public function destroy($id)
    {
        $user = User::with('units', 'actions')->findOrFail($id);

        // if the unit has users, do not delete
        if (count($user->units) > 0) {
            Session::flash('flash_message', trans('entities/users.hasUnits'));
            Session::flash('flash_type', 'alert-danger');

            return;
        }
        if (count($user->actions) > 0) {
            Session::flash('flash_message', trans('entities/users.hasActions'));
            Session::flash('flash_type', 'alert-danger');

            return;
        }

        $user->delete();

        Session::flash('flash_message', trans('entities/users.deleted'));
        Session::flash('flash_type', 'alert-success');

    }

    /**
     * Search all users
     *
     * @return mixed
     */
    public function search()
    {
        $users = $this->userService->search();

        return $users;
    }
}
