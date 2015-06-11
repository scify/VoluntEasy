<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Models\Unit as Unit;
use Illuminate\Http\Request;

class UnitController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $units = Unit::all();

        return view("main.units.list", compact('units'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
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
        //
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
