<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Requests\UserRequest as UserRequest;
use App\Models\Unit;
use App\Models\User as User;
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
        $users = User::all();

        return view("main.users.list", compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view("main.users.create");
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

        return Redirect::to('main/users');
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

        return view("main.users.show", compact('user'));
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

        $units = Unit::whereNull('parent_unit_id')->with('parent', 'children')->get();

        return view("main.users.edit", compact('user', 'units'));
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

        $user->update($request->all());

        return Redirect::to('main/users');
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

        return Redirect::to('main/users');
    }

}
