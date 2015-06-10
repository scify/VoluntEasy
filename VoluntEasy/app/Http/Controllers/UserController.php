<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Models\User as User;
use Illuminate\Support\Facades\Input as Input;

class UserController extends Controller
{

    protected $_validator;

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

        return view("main.users.listview", compact('users'));
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
     * @return Response
     */
    public function store()
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {
        $user = User::findOrFail($id);

        return view("main.users.edit", compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);


        return view("main.users.edit", compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @return Response
     */
    public function update()
    {
        // create a new model instance
        $user = new User();

        // attempt validation
        if ($user->validate(Input::all()))
        {
            echo 'cool';
        }
        else
        {
            dd($user->errors());
        }

        // attempt validation
        /*if ()
        {
            // success code
        }
        else
        {
            // failure
        }
*/
        /*  $user = User::findOrFailt($id);
          $user->update($request->all());

          dd($user);

          return Redirect::to('');*/
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }

}
