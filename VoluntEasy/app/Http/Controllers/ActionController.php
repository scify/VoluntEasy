<?php namespace App\Http\Controllers;

use App\Http\Requests\ActionRequest as ActionRequest;
use App\Models\Action;
use App\Services\Facades\UnitService;
use Illuminate\Support\Facades\Redirect;

class ActionController extends Controller
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
        $actions = Action::all();
        $actions->load('unit');

        return view("main.actions.list", compact('actions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $tree = UnitService::getTree();

        return view('main.actions.create', compact('tree'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(ActionRequest $request)
    {
        Action::create($request->all());


        return Redirect::to('main/actions');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {
        $action = Action::find($id)->first();
        $action->load('unit');

        return view('main.actions.show', compact('action'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @return Response
     */
    public function update($id)
    {
        //
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
