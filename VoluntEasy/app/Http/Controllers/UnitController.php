<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Models\Unit as Unit;
use App\Http\Requests\UnitRequest as UnitRequest;
use Illuminate\Support\Facades\Redirect;
use App\Helpers\UnitHelper as UnitHelper;

class UnitController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $units = Unit::whereRaw('parent_unit_id=id')->with('parent', 'children')->get();

        return view("main.units.list", compact('units'));
    }

    /**
     * Get the tree with its branches in JSON format
     *
     * @return mixed
     */
    public function all($id)
    {
        $units = Unit::where('id', '=', $id)->with('allChildren')->first();

        $units->allChildren();

        return $units;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view("main.units.create");
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
        $unit = Unit::where('id', '=', $id)->with('allChildren')->first();

        $unit->allChildren();

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
