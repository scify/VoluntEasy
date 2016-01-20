<?php namespace App\Http\Controllers;

use App\Http\Requests\ActionRequest as ActionRequest;
use App\Models\Action;
use App\Models\ActionTasks\Status;
use App\Models\ActionVolunteerHistory;
use App\Models\Descriptions\VolunteerStatus;
use App\Models\Rating\ActionRatingAttribute;
use App\Models\Rating\ActionScore;
use App\Models\Unit;
use App\Models\Volunteer;
use App\Services\Facades\ActionService;
use App\Services\Facades\UnitService;
use App\Services\Facades\UserService;
use App\Services\Facades\VolunteerService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class ActionController extends Controller {

    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        $actions = Action::with('unit', 'volunteers')->get();

        foreach ($actions as $action) {
            $action->unit->branch = UnitService::getBranchString($action->unit);
        }

        // $actions->setPath(\URL::to('/') . '/actions');

        $userUnits = UserService::userUnits();

        return view("main.actions.list", compact('actions', 'userUnits'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        $tree = UnitService::getTree();

        $userUnits = UserService::userUnits();

        return view('main.actions.create', compact('tree', 'userUnits'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ActionRequest $request
     * @return Response
     */
    public function store(ActionRequest $request) {

        $request['start_date'] = \Carbon::createFromFormat('d/m/Y', $request->start_date);
        $request['end_date'] = \Carbon::createFromFormat('d/m/Y', $request->end_date);
        $action = Action::create($request->all());

        if ($request->ajax())
            return $action->unit_id;
        else
            return Redirect::route('action/one', ['id' => $action->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id) {
        $action = Action::with('unit', 'ratings', 'tasks')->findOrFail($id);

        $branch = UnitService::getBranch(Unit::where('id', $action->unit->id)->with('actions')->first());

        //get the volunteer ids in an array for the select box
        $volunteerIds = VolunteerService::volunteerIds($action->volunteers);

        $unitId = $action->unit_id;
        //get all volunteers to show in select box
        //those should be the volunteers that belong to the same unit
        //that the action belongs to
        $allVolunteers = Volunteer::whereHas('units', function ($query) use ($unitId) {
            $query->where('unit_id', $unitId);
        })->orderBy('name', 'asc')->get();

        //check if action has expired
        $now = date('Y-m-d');
        $endDate = \Carbon::parse(\Carbon::createFromFormat('d/m/Y', $action->end_date))->format('Y-m-d');
        $action->expired = false;
        if ($endDate < $now)
            $action->expired = true;

        $userUnits = UserService::userUnits();

        $taskStatuses = Status::all();

        return view('main.actions.show', compact('action', 'allVolunteers', 'volunteerIds', 'userUnits', 'branch', 'taskStatuses'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id) {
        $action = Action::where('id', $id)->first();
        $actives = [$action->id];

        $userUnits = UserService::userUnits();

        return view('main.actions.edit', compact('action', 'actives', 'userUnits'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  ActionRequest $request
     * @return Response
     */
    public function update(ActionRequest $request) {
        $action = Action::findOrFail($request->get('id'));

        $request['start_date'] = \Carbon::createFromFormat('d/m/Y', $request->start_date);
        $request['end_date'] = \Carbon::createFromFormat('d/m/Y', $request->end_date);

        $action->update($request->all());

        return Redirect::route('action/one', ['id' => $action->id]);
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
            $oldVolunteersOfAction = $action->volunteers()->get()->lists('id')->all();

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


    public function fullRatings($id) {
        $action = Action::findOrFail($id);
        $ratings = ActionScore::where('action_id', $id)->with('ratings')->get();

        $attributes = ActionRatingAttribute::all();

        foreach ($ratings as $rating) {
            foreach ($rating->ratings as $score) {
                switch($score->score){
                    case "-2":
                        $score->description = "Διαφωνώ απόλυτα";
                        break;
                    case "-1":
                        $score->description = "Διαφωνώ";
                        break;
                    case "0":
                        $score->description = "Ούτε διαφωνώ/ούτε συμφωνώ";
                        break;
                    case "1":
                        $score->description = "Συμφωνώ";
                        break;
                    case "2":
                        $score->description = "Συμφωνώ απόλυτα";
                        break;
                }
            }
        }

        //return $ratings;
        return view('main.actions.ratings', compact('action', 'attributes', 'ratings'));
    }

}
