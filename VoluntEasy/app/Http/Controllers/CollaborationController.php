<?php namespace App\Http\Controllers;

use App\Http\Requests\CollaborationRequest;
use App\Models\Action;
use App\Models\ActionVolunteerHistory;
use App\Models\Collaboration;
use App\Models\Descriptions\VolunteerStatus;
use App\Models\Executive;
use App\Services\Facades\ActionService;
use App\Services\Facades\VolunteerService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class CollaborationController extends Controller {

    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        $collaborations = Collaboration::all();

        return view("main.collaborations.list", compact('collaborations'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        return view('main.collaborations.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CollaborationRequest $request
     * @return Response
     */
    public function store(CollaborationRequest $request) {

        $request['start_date'] = \Carbon::createFromFormat('d/m/Y', $request->start_date);
        $request['end_date'] = \Carbon::createFromFormat('d/m/Y', $request->end_date);
        $collaboration = Collaboration::create($request->only('start_date', 'end_date', 'name', 'type', 'phone', 'address', 'comments'));

        //create the executive obj
        if ($request['execName']) {
            $executive = Executive::create([
                'name' => $request['execName'],
                'address' => $request['execAddress'],
                'phone' => $request['execPhone'],
                'email' => $request['execEmail']]);

            //assign to the collaboration
            $collaboration->executives()->save($executive);
        }

        return Redirect::route('collaboration/one', ['id' => $collaboration->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id) {
        $collaboration = Collaboration::with('executives')->findOrFail($id);

        //check if collaboration has expired
        $now = date('Y-m-d');
        $endDate = \Carbon::parse(\Carbon::createFromFormat('d/m/Y', $collaboration->end_date))->format('Y-m-d');
        $collaboration->expired = false;
        if ($endDate < $now)
            $collaboration->expired = true;

        return view('main.collaborations.show', compact('collaboration'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id) {
        $collaboration = Collaboration::with('executives', 'files')->findOrFail($id);

        return view('main.collaborations.edit', compact('collaboration'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  CollaborationRequest $request
     * @return Response
     */
    public function update(CollaborationRequest $request) {
        $collaboration = Collaboration::findOrFail($request->get('id'));

        $request['start_date'] = \Carbon::createFromFormat('d/m/Y', $request->start_date);
        $request['end_date'] = \Carbon::createFromFormat('d/m/Y', $request->end_date);

        $collaboration->update($request->only('start_date', 'end_date', 'name', 'type', 'phone', 'address', 'comments'));

        //update the executive obj
        if ($request->has('executive_id')) {
            $executive = Executive::find($request['executive_id']);
            if ($executive != null) {
                $executive->name = $request['execName'];
                $executive->address = $request['execAddress'];
                $executive->phone = $request['execPhone'];
                $executive->email = $request['execEmail'];

                $executive->save();
            }
        }

        return Redirect::route('collaboration/one', ['id' => $collaboration->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id) {
        $action = Action::findOrFail($id);
        $action->load('volunteers');

        //if the action has volunteers, do not delete
        if (sizeof($action->volunteers) > 0) {
            Session::flash('flash_message', 'Η δράση περιέχει εθελοντές και δεν μπορεί να διαγραφεί.');
            Session::flash('flash_type', 'alert-danger');
            return;
        }

        Session::flash('flash_message', 'Η δράση διαγράφηκε.');
        Session::flash('flash_type', 'alert-success');

        $action->delete();

        return;
    }

    /**
     * Search all actions
     *
     * @return mixed
     */
    public function search() {
        $actions = ActionService::search();

        return $actions;
    }

    /**
     * Sync the action volunteers with the db.
     *
     * @param Request $request
     * @return mixed
     */
    public function addVolunteers(Request $request) {

        $action = Action::whereId($request->get('id'))->first();

        //if there are no volunteers, remove all
        if (sizeof($request->get('volunteers')) == 0) {
            $action->volunteers()->detach();
        } else {
            $oldVolunteersOfAction = $action->volunteers()->get()->lists('id');

            $action->volunteers()->sync($request->get('volunteers'));
            $statusId = VolunteerStatus::active();

            // create a history entry for each new volunteer
            foreach ($request->get('volunteers') as $volunteer) {
                if (!in_array($volunteer, $oldVolunteersOfAction)) {
                    VolunteerService::actionHistory($volunteer, $action->id);

                    //change unit status to active
                    VolunteerService::changeUnitStatus($volunteer, $action->unit_id, $statusId);
                }
            }
        }

        return $action->id;
    }


}
