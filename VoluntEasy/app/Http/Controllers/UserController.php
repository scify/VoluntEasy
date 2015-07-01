<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Requests\UserRequest as UserRequest;
use App\Models\User as User;
use App\Services\Facades\UnitService;
use App\Services\Facades\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $users = User::orderBy('name', 'ASC')->get();

        return view("main.users.list", compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $tree = UnitService::getTree();

        return view("main.users.create", compact('tree'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param UserRequest $request
     * @return Response
     */
    public function store(UserRequest $request)
    {
        $request['password'] = \Hash::make($request['password']);

        User::create($request->all());

        return Redirect::to('users');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {
        $user = User::where('id', $id)->with('units')->first();


        $tree = UnitService::getTree();

        return view("main.users.show", compact('user', 'tree'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        $user = User::where('id', $id)->with('units.allChildren')->first();

        $tree = UnitService::getTree();

        $active = UserService::userUnitsIds($user);

        return view("main.users.edit", compact('user', 'tree', 'active'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UserRequest $request
     * @return Response
     */

    public function update(UserRequest $request)
    {
        $user = User::findOrFail($request->get('id'));

        $request['password'] = \Hash::make($request['password']);


        $user->update($request->all());

        return Redirect::to('users');
    }

    public function addUnits(Request $request)
    {

        $user = User::findOrFail($request->get('id'));

        $user->units()->sync($request->get('units'));

        return $user->id;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        $user->delete();

        return $id;
    }

}
