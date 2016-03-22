<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Requests\UserRequest as UserRequest;
use App\Models\Action;
use App\Models\Roles\Role;
use App\Models\Unit;
use App\Models\User as User;
use App\Services\Facades\NotificationService;
use App\Services\Facades\UnitService;
use App\Services\Facades\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class UserController extends Controller {

    public function __construct() {
        $this->middleware('auth');
        $this->middleware('permissions.user', ['only' => ['edit']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        return view("main.users.list");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {

        $roles = Role::all(['name', 'id']);
        $units = Unit::whereNotNull('parent_unit_id')->get(['description', 'id']);
        $actions = Action::all(['description', 'id', 'unit_id']);
        $permittedUnits = UserService::permittedUnits();

        return view("main.users.create", compact('roles', 'units', 'permittedUnits', 'actions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param UserRequest $request
     * @return Response
     */
    public function store(UserRequest $request) {
        $request['password'] = \Hash::make($request['password']);
        $user = User::create($request->all());

        /*
                //send email to notify user for new account
                \Mail::send('emails.new_user', ['user' => $user], function ($message) use ($user) {
                    $message->to($user->email, $user->name)->subject('Welcome to VoluntEasy');
                });
        */

        //store the user image
        if (\Input::file('image') != null) {
            $user->update(['image_name' => UserService::storeImage(\Input::file('image'), $user->email)]);
        }

        //refresh user roles
        if (\Request::has('roles'))
        $user->refreshRoles(\Request::get('roles'));

        return Redirect::route('user/profile', ['id' => $user->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id) {
        $user = User::where('id', $id)->with('units', 'roles')->first();

        $isAdmin = UserService::isAdmin($id);

        $tree = UnitService::getTree();

        $permittedUsers = UserService::permittedUsersIds();

        return view("main.users.show", compact('user', 'tree', 'permittedUsers', 'isAdmin'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id) {

        //  $roles = ['admin' => 'Διαχειριστής', 'unit_manager' => 'Υπεύθυνος Μονάδων', 'action_manager' => 'Υπεύθυνος Δράσης'];
        $roles = Role::all(['name', 'id']);
        //get all units except for the root unit
        $units = Unit::whereNotNull('parent_unit_id')->get(['description', 'id']);
        $actions = Action::all(['description', 'id', 'unit_id']);
        $permittedUnits = UserService::permittedUnits();

        $user = User::where('id', $id)->first();

        return view("main.users.edit", compact('user', 'roles', 'units', 'actions', 'userUnits', 'permittedUnits'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UserRequest $request
     * @return Response
     */
    public function update(UserRequest $request) {

        $user = User::findOrFail($request->get('id'));

        if ($request['password'] != null && $request['password'] != '') {
            $request['password'] = \Hash::make($request['password']);
            $user->update($request->all());
        } else {
            $user->update([
                'name' => $request['name'],
                'email' => $request['email'],
                'addr' => $request['addr'],
                'tel' => $request['tel'],
            ]);
        }

        //refresh user roles
        if(\Request::has('roles'))
            $user->refreshRoles(\Request::get('roles'));

        //store the user image
        if (\Input::file('image') != null) {
            $user->update(['image_name' => UserService::storeImage(\Input::file('image'), $user->email)]);
        }

        return Redirect::route('user/profile', ['id' => $user->id]);
    }

    /**
     * Assign user to multiple units
     *
     * @param Request $request
     * @return mixed
     */
    public function addUnits(Request $request) {
        $user = User::findOrFail($request->get('id'));

        if ($request->get('units') == null)
            $user->units()->detach();
        else
            $user->units()->sync($request->get('units'));

        //notify user that they 're added to unit
        foreach ($request->get('units') as $unitId) {
            $unit = Unit::find($unitId);
            NotificationService::userToUnit($user->id, $unit);
        }

        return $user->id;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id) {
        $user = User::findOrFail($id);

        //if the unit has users, do not delete
        if (sizeof($user->units) > 0) {
            Session::flash('flash_message', 'Ο χρήστης είναι υπεύθυνος σε μονάδες και δεν μπορεί να διαγραφεί.');
            Session::flash('flash_type', 'alert-danger');

            return;
        }

        $user->delete();

        Session::flash('flash_message', 'Ο χρήστης διαγράφηκε.');
        Session::flash('flash_type', 'alert-success');

        return;
    }

    /**
     * Show the tasks for a user
     *
     * @param $id
     * @return \Illuminate\View\View
     */
    public function tasks($id) {
        $user = User::with('units.volunteers')->get();

        /*  foreach($user->units as $unit){
              foreach($unit->volunteers as $volunteer){
                  $volunteer = VolunteerService::fullProfile($volunteer);
              }
          }
  */
        return view("main.users.tasks", compact('user'));
    }

    /**
     * Search all users
     *
     * @return mixed
     */
    public function search() {
        $users = UserService::search();

        return $users;
    }

}
