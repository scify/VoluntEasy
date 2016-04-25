<?php namespace App\Http\Controllers;

use App\Http\Requests\ActionRequest as ActionRequest;
use App\Models\Action;
use App\Models\ActionTasks\Status;
use App\Models\ActionVolunteerHistory;
use App\Models\Descriptions\VolunteerStatus;
use App\Models\Rating\ActionRatingAttribute;
use App\Models\Rating\ActionScore;
use App\Models\Roles\Role;
use App\Models\Unit;
use App\Models\User;
use App\Models\Volunteer;
use App\Services\Facades\ActionService;
use App\Services\Facades\CTAService;
use App\Services\Facades\SubtaskService;
use App\Services\Facades\TaskService;
use App\Services\Facades\UnitService;
use App\Services\Facades\UserService;
use App\Services\Facades\VolunteerService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class ActionController extends Controller {

    private $configuration;

    public function __construct() {
        $this->middleware('auth');
        $this->configuration = \App::make('Interfaces\ConfigurationInterface');

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

        $configuration = $this->configuration;

        return view('main.actions.create', compact('tree', 'userUnits', 'configuration'));
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
        $action = Action::with('unit.volunteers', 'users', 'ratings', 'tasks.subtasks.status', 'tasks.subtasks.shifts', 'tasks.subtasks.checklist', 'tasks.users', 'tasks.volunteers', 'publicAction.subtasks')->findOrFail($id);

        $branch = UnitService::getBranch(Unit::where('id', $action->unit->id)->with('actions')->first());

        /*//get the volunteer ids in an array for the select box
        $volunteerIds = VolunteerService::volunteerIds($action->volunteers);
*/
        $unitId = $action->unit_id;

        //check if action has expired
        $now = date('Y-m-d');
        $endDate = \Carbon::parse(\Carbon::createFromFormat('d/m/Y', $action->end_date))->format('Y-m-d');
        $action->expired = false;
        if ($endDate < $now)
            $action->expired = true;

        $userUnits = UserService::userUnits();
        $userActions = UserService::userActions();
        if (in_array($action->unit->id, $userUnits) || in_array($action->id, $userActions))
            $isPermitted = true;
        else
            $isPermitted = false;

        $taskStatuses = Status::all();

        //get subtasks per status, calculate total volunteer sum etc
        $action = TaskService::prepareTasks($action);

        //get all users that can assigned to a task
        $users = User::orderBy('name')->get();
        $usersToAssign[0] = trans('entities/search.choose');
        foreach($users as $user){
            $usersToAssign[$user->id]=$user->fullName;
        }

        $volunteersToAssign[0] = trans('entities/search.choose');
        foreach($action->unit->volunteers as $volunteer){
            $volunteersToAssign[$volunteer->id]=$volunteer->fullName;
        }

        if ($action->publicAction != null)
            $publicSubtasks = CTAService::getPublicSubtasks($action);

        $configuration = $this->configuration;

        return view('main.actions.show', compact('action', 'userUnits', 'branch', 'taskStatuses', 'publicSubtasks', 'usersToAssign', 'volunteersToAssign', 'isPermitted', 'configuration'));
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

        $configuration = $this->configuration;

        return view('main.actions.edit', compact('action', 'actives', 'userUnits', 'configuration'));
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
        $action = Action::with('volunteers', 'tasks.subtasks.shifts', 'users', 'ratings', 'actionRatings', 'publicAction')->findOrFail($id);

        //first delete any task, subtask and shifts associated with the action
        foreach ($action->tasks as $task) {
            foreach ($task->subtasks as $subtask) {
                SubtaskService::delete($subtask);
            }
            $task->delete();
        }

        //remove all volunteers and set their status to available
        foreach ($action->volunteers as $volunteer) {
            VolunteerService::removeFromAction($volunteer, $action);
        }

        //remove all users, and check if their role should be updated
        foreach ($action->users as $user) {
            $user->actions()->detach($action->id);
            $user->load('roles');
            $user->load('actions');
            if (in_array('action_manager', $user->roles->lists('name')->toArray()) && sizeof($user->actions) == 0) {
                $actionManagerId = Role::where('name', 'action_manager')->first(["id"])->id;
                $user->roles()->detach($actionManagerId);
            }
        }


        /*$action->ratings()->delete();//check
        $action->actionRatings()->delete();//check*/
        $action->publicAction()->delete();
        $action->delete();

        Session::flash('flash_message', trans('entities/actions.deleted'));
        Session::flash('flash_type', 'alert-success');

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
                switch ($score->score) {
                    case "-2":
                        $score->description = trans('entities/ratings.fullyDisagree');
                        break;
                    case "-1":
                        $score->description = trans('entities/ratings.disagree');
                        break;
                    case "0":
                        $score->description = trans('entities/ratings.neutral');
                        break;
                    case "1":
                        $score->description = trans('entities/ratings.Agree');
                        break;
                    case "2":
                        $score->description = trans('entities/ratings.fullyAgree');
                        break;
                }
            }
        }

        //return $ratings;
        return view('main.actions.ratings', compact('action', 'attributes', 'ratings'));
    }

}
