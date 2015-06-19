<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Requests\UnitRequest as UnitRequest;
use App\Models\Unit as Unit;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\View;

class UnitController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $units = Unit::whereNull('parent_unit_id')->with('parent', 'children', 'actions')->get();

        return view("main.units.list", compact('units'));
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
     *
     * @return Response
     */
    public function createRoot()
    {
        $type='root';
        return view("main.units.create_root", compact('type'));
    }

    public function createBranch($id)
    {
        $unit = Unit::where('id', $id)->with('allChildren')->first();

        $type='branch';

        return view("main.units.create_branch", compact('unit', 'type'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param UnitRequest $request
     * @return Response
     */
    public function store(UnitRequest $request)
    {
        Unit::create($request->all());

        return Redirect::to('main/units');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {
        $unit = Unit::where('id', $id)->with('allChildren', 'users')->first();

        //if the request comes from ajax, return only a section of the needed code
        if (Request::ajax()) {
            $view = View::make('main.units.show')->with('unit', $unit);
            return $view->renderSections()['details'];
        }

        return view("main.units.show", compact('unit'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        $unit = Unit::where('id', $id)->first();

        if($unit->parent_unit_id==null) {
            $type = 'root';
            $unit->load('allChildren');
        }
        else {
            $type = 'branch';
            $unit->load('allParents.allChildren');
        }

        return view("main.units.edit", compact('unit', 'type'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UnitRequest $request
     * @return Response
     */
    public function update(UnitRequest $request)
    {
        $unit = Unit::findOrFail($request->get('id'));

        $unit->update($request->all());

        return view('main.units.show', compact('unit'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        $unit = Unit::findOrFail($id);

        $unit->delete();

        return Redirect::to('main/units');
    }


    /**
     * Test and play
     *
     * @return Response
     */
    public function test()
    {
        $unit = Unit::find(8);


        $lala = Unit::parent($unit->parent_unit_id)->get();

        return $lala;

        /* return Unit::all();*/
    }

}
