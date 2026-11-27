<?php

namespace App\Http\Controllers;

use App\Http\Requests\ActionRequest;
use App\Models\Action;
use App\Models\ActionTasks\Status;
use App\Models\Descriptions\VolunteerStatus;
use App\Models\Rating\ActionRatingAttribute;
use App\Models\Rating\ActionScore;
use App\Models\Roles\Role;
use App\Models\Unit;
use App\Models\User;
use App\Models\Volunteer;
use App\Services\ActionService;
use App\Services\CTAService;
use App\Services\SubtaskService;
use App\Services\TaskService;
use App\Services\UnitService;
use App\Services\UserService;
use App\Services\Volunteers\VolunteerAssignment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Interfaces\ConfigurationInterface;

class ActionController extends Controller
{
    private ActionService $actionService;

    private CTAService $cTAService;

    private SubtaskService $subtaskService;

    private TaskService $taskService;

    private UnitService $unitService;

    private UserService $userService;

    private VolunteerAssignment $volunteerAssignment;

    private $configuration;

    public function __construct(ConfigurationInterface $configuration, VolunteerAssignment $volunteerAssignment, ActionService $actionService, CTAService $cTAService, SubtaskService $subtaskService, TaskService $taskService, UnitService $unitService, UserService $userService)
    {
        $this->actionService = $actionService;
        $this->cTAService = $cTAService;
        $this->subtaskService = $subtaskService;
        $this->taskService = $taskService;
        $this->unitService = $unitService;
        $this->userService = $userService;
        $this->volunteerAssignment = $volunteerAssignment;
        $this->middleware('auth');
        $this->configuration = $configuration;

    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $actions = Action::with('unit', 'volunteers')->get();

        foreach ($actions as $action) {
            $action->unit->branch = $this->unitService->getBranchString($action->unit);
        }

        // $actions->setPath(\URL::to('/') . '/actions');

        $userUnits = $this->userService->userUnits();

        return view('main.actions.list', compact('actions', 'userUnits'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tree = $this->unitService->getTree();

        $userUnits = $this->userService->userUnits();

        $configuration = $this->configuration;

        return view('main.actions.create', compact('tree', 'userUnits', 'configuration'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ActionRequest $request)
    {

        $request['start_date'] = \Carbon::createFromFormat('d/m/Y', $request->start_date);
        $request['end_date'] = \Carbon::createFromFormat('d/m/Y', $request->end_date);
        $action = Action::create($request->all());

        if ($request->ajax()) {
            return $action->unit_id;
        } else {
            return Redirect::route('action/one', ['id' => $action->id]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     */
    public function show($id)
    {
        $action = Action::with('unit.volunteers', 'users', 'ratings',
            'tasks.users', 'tasks.volunteers', 'tasks.shifts.volunteers',
            'tasks.subtasks.status', 'tasks.subtasks.shifts.volunteers', 'tasks.subtasks.checklist', 'tasks.subtasks.users', 'tasks.subtasks.volunteers',
            'publicAction.subtasks')
            ->findOrFail($id);

        $branch = $this->unitService->getBranch(Unit::where('id', $action->unit->id)->with('actions')->first());

        $unitId = $action->unit_id;

        // check if action has expired
        $now = date('Y-m-d');
        $endDate = \Carbon::parse(\Carbon::createFromFormat('d/m/Y', $action->end_date))->format('Y-m-d');
        $action->expired = false;
        if ($endDate < $now) {
            $action->expired = true;
        }

        $userUnits = $this->userService->userUnits();
        $userActions = $this->userService->userActions();
        if (in_array($action->unit->id, $userUnits) || in_array($action->id, $userActions)) {
            $isPermitted = true;
        } else {
            $isPermitted = false;
        }

        $taskStatuses = Status::all();

        // get subtasks per status, calculate total volunteer sum etc
        $action = $this->taskService->prepareTasks($action);

        // get all users that can assigned to a task
        $users = User::orderBy('name')->get();
        $usersToAssign[0] = trans('entities/search.choose');
        foreach ($users as $user) {
            $usersToAssign[$user->id] = $user->fullName;
        }

        $volunteersToAssign[0] = trans('entities/search.choose');
        foreach ($action->unit->volunteers as $volunteer) {
            $volunteersToAssign[$volunteer->id] = $volunteer->fullName;
        }

        $publicSubtasks = null;
        if ($action->publicAction != null) {
            $publicSubtasks = $this->cTAService->getPublicSubtasks($action);
        }

        $configuration = $this->configuration;

        return view('main.actions.show', compact('action', 'userUnits', 'branch', 'taskStatuses', 'publicSubtasks', 'usersToAssign', 'volunteersToAssign', 'isPermitted', 'configuration'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     */
    public function edit($id)
    {
        $action = Action::where('id', $id)->first();
        $actives = [$action->id];

        $userUnits = $this->userService->userUnits();

        $configuration = $this->configuration;

        return view('main.actions.edit', compact('action', 'actives', 'userUnits', 'configuration'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ActionRequest $request)
    {
        $action = Action::findOrFail($request->get('id'));

        $request['start_date'] = \Carbon::createFromFormat('d/m/Y', $request->start_date);
        $request['end_date'] = \Carbon::createFromFormat('d/m/Y', $request->end_date);

        $action->update($request->all());

        return Redirect::route('action/one', ['id' => $action->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     */
    public function destroy($id)
    {
        $action = Action::with('volunteers', 'tasks.subtasks.shifts', 'users', 'ratings', 'actionRatings', 'publicAction')->findOrFail($id);

        // first delete any task, subtask and shifts associated with the action
        foreach ($action->tasks as $task) {
            foreach ($task->subtasks as $subtask) {
                $this->subtaskService->delete($subtask);
            }
            $task->delete();
        }

        // remove all volunteers and set their status to available
        foreach ($action->volunteers as $volunteer) {
            $this->volunteerAssignment->removeFromAction($volunteer, $action);
        }

        // remove all users, and check if their role should be updated
        foreach ($action->users as $user) {
            $user->actions()->detach($action->id);
            $user->load('roles');
            $user->load('actions');
            if (in_array('action_manager', $user->roles->pluck('name')->toArray()) && count($user->actions) == 0) {
                $actionManagerId = Role::where('name', 'action_manager')->first(['id'])->id;
                $user->roles()->detach($actionManagerId);
            }
        }

        /*$action->ratings()->delete();//check
        $action->actionRatings()->delete();//check*/
        $action->publicAction()->delete();
        $action->delete();

        Session::flash('flash_message', trans('entities/actions.deleted'));
        Session::flash('flash_type', 'alert-success');

    }

    /**
     * Search all actions
     *
     * @return mixed
     */
    public function search()
    {
        $actions = $this->actionService->search();

        return $actions;
    }

    /**
     * Sync the action volunteers with the db.
     *
     * @return mixed
     */
    public function addVolunteers(Request $request)
    {

        $action = Action::whereId($request->get('id'))->first();

        // if there are no volunteers, remove all
        if (count($request->get('volunteers')) == 0) {
            $action->volunteers()->detach();
        } else {
            $oldVolunteersOfAction = $action->volunteers()->pluck('volunteers.id')->all();

            $action->volunteers()->sync($request->get('volunteers'));
            $statusId = VolunteerStatus::active();

            // create a history entry for each new volunteer
            foreach ($request->get('volunteers') as $volunteer) {
                if (! in_array($volunteer, $oldVolunteersOfAction)) {
                    $this->volunteerAssignment->actionHistory($volunteer, $action->id);

                    // change unit status to active
                    $this->volunteerAssignment->changeUnitStatus($volunteer, $action->unit_id, $statusId);
                }
            }
        }

        return $action->id;
    }

    public function fullRatings($id)
    {
        $action = Action::findOrFail($id);
        $ratings = ActionScore::where('action_id', $id)->with('ratings')->get();

        $attributes = ActionRatingAttribute::all();

        foreach ($ratings as $rating) {
            foreach ($rating->ratings as $score) {
                switch ($score->score) {
                    case '-2':
                        $score->description = trans('entities/ratings.fullyDisagree');
                        break;
                    case '-1':
                        $score->description = trans('entities/ratings.disagree');
                        break;
                    case '0':
                        $score->description = trans('entities/ratings.neutral');
                        break;
                    case '1':
                        $score->description = trans('entities/ratings.Agree');
                        break;
                    case '2':
                        $score->description = trans('entities/ratings.fullyAgree');
                        break;
                }
            }
        }

        // return $ratings;
        return view('main.actions.ratings', compact('action', 'attributes', 'ratings'));
    }
}
