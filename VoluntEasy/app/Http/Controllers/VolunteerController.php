<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Models\Volunteer;
use App\Services\Facades\VolunteerService;

class VolunteerController extends Controller
{
    public function all()
    {

        $vol = Volunteer::all();

        $vol->load('availabilityFrequencies', 'availabilityTimes', 'driverLicenceType', 'identificationType', 'maritalStatus', 'interests');

        $vol->load('languages.level', 'languages.language');

        $vol->load('actions.steps.status');

        return $vol;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return view('main.volunteers.list');
    }

    /**
     * Display new volunteer form
     *
     * @return \Illuminate\View\View
     */
    public function newVolunteer()
    {
        return view('main.volunteers.new');
    }


    /**
     * Display volunteer statistics
     *
     * @return \Illuminate\View\View
     */
    public function statistics()
    {
        return view('main.volunteers.statistics');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public
    function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public
    function store()
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public
    function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public
    function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @return Response
     */
    public
    function update($id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public
    function destroy($id)
    {
        //
    }

    public function getNew(){
        return VolunteerService::getNew();
    }

}
