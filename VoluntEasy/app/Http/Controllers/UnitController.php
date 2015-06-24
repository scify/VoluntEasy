<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Requests\UnitRequest as UnitRequest;
use App\Models\Unit as Unit;
use App\Services\Facades\UnitServiceFacade as UnitService;
use Illuminate\Support\Facades\Redirect;

class UnitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $units = Unit::orderBy('description', 'ASC')->get();

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
    public function create()
    {
        $root = UnitService::getRoot();

        if(count($root)==0) {
            $type='root';
            return view("main.units.create_root", compact('type'));
        }
        else {
            $tree = Unit::whereNull('parent_unit_id')->with('allChildren')->first();
            $type='branch';
            return view("main.units.create_branch", compact('type', 'tree'));
        }
    }

    public function createBranch($id)
    {
        $unit = Unit::where('id', $id)->with('allChildren')->first();

        $tree = Unit::whereNull('parent_unit_id')->with('allChildren')->first();

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
        $active = Unit::where('id', $id)->first();

        $tree = UnitService::getTree();


        //if the request comes from ajax, return only a section of the needed code
       /* if (Request::ajax()) {
            $view = View::make('main.units.show')->with('active', $active);
            return $view->renderSections()['details'];
        }
        */

        return view("main.units.show", compact('active', 'tree'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        $active = Unit::where('id', $id)->first();

        $tree = UnitService::getTree();

        $type = UnitService::type($active->parent_unit_id);

        return view("main.units.edit", compact('active', 'tree', 'type'));
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

        return Redirect::route('unit/one', ['id' => $unit->id]);
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

}
