<?php namespace App\Http\Controllers;

use App\Models\ActionTasks\Status;
use App\Models\ActionTasks\SubTask;
use App\Models\ActionTasks\Task;
use App\Models\Volunteer;
use App\Services\Facades\SubtaskService;
use App\Services\Facades\TaskService;

class SubTaskController extends Controller
{


    public function __construct()
    {
        $this->middleware('auth');
    }


    /**
     * View a certain subtask
     *
     * @param $id
     * @return mixed
     */
    public function show($id)
    {
        $subTask = SubTask::with('users', 'volunteers', 'shifts.volunteers', 'checklist.createdBy', 'checklist.updatedBy', 'workDates.ctaVolunteers.volunteer', 'action')->findOrFail($id);

        $unitId = $subTask->action->unit_id;
        //get all volunteers to show in select box
        //those should be the volunteers that belong to the same unit
        //that the action belongs to
        $unitVolunteers = Volunteer::whereHas('units', function ($query) use ($unitId) {
            $query->where('unit_id', $unitId);
        })->orderBy('name', 'asc')->get()->toArray();


        //check if cta volunteer already exists in db, based on the email
        foreach ($subTask->shifts as $i => $date) {
            foreach ($date->ctaVolunteers as $j => $cta) {
                //volunteer is already assigned to a profile
                if (sizeof($cta->volunteer) > 0) {
                    foreach ($unitVolunteers as $k => $uv) {
                        //return $uv['id'];
                        if ($uv['id'] == $cta->volunteer[0]->id)
                            unset($subTask->shifts[$i]->ctaVolunteers[$j]);

                        /*
                                                //if the volunteer is already assigned to the work date, remove from the array
                                                foreach($date->volunteers as $volunteer){
                                                        if($uv['id']==$volunteer->id){
                                                            unset($unitVolunteers[$k]);
                                                        }
                                                }
                        */
                    }
                } else {
                    $cta->mightBe = Volunteer::where('email', $cta->email)->first();
                }
            }

        }

        $subTask->unitVolunteers = $unitVolunteers;
        unset($subTask->action);

        return $subTask;
    }

    /**
     * Store a subtask
     */
    public function store()
    {

        $todo = Status::todo();

        if (\Request::has('subtask-due_date'))
            $due_date = \Carbon::createFromFormat('d/m/Y', \Request::get('subtask-due_date'));
        else
            $due_date = null;

        $subTask = new SubTask([
            'name' => \Request::get('subtask-name'),
            'description' => \Request::get('subtask-description'),
            'priority' => \Request::get('subtask-priorities'),
            'task_id' => \Request::get('taskId'),
            'action_id' => \Request::get('actionId'),
            'due_date' => $due_date,
            'status_id' => $todo
        ]);

        $subTask->save();

        SubtaskService::syncUsers($subTask);
        SubtaskService::syncVolunteers($subTask);

        return $subTask;
    }

    /**
     * Update a subtask
     */
    public function update()
    {
        $subTask = SubTask::with('shifts')->find(\Request::get('subTaskId'));

        if (\Request::has('subtask-due_date'))
            $due_date = \Carbon::createFromFormat('d/m/Y', \Request::get('subtask-due_date'));
        else
            $due_date = null;

        $subTask->update([
            'name' => \Request::get('subtask-name'),
            'description' => \Request::get('subtask-description'),
            'priority' => \Request::get('subtask-priorities'),
            'due_date' => $due_date
        ]);

        SubtaskService::syncUsers($subTask);
        SubtaskService::syncVolunteers($subTask);

        return $subTask;
    }

    /**
     * Update a subtask's status
     */
    public function updateStatus()
    {

        $subTask = SubTask::find(\Request::get('subTaskId'));

        $status = Status::where('description', \Request::get('status'))->first()->id;
        $subTask->update(['status_id' => $status]);

        $task = Task::with('subtasks')->find($subTask->task_id);

        $taskStatus = TaskService::taskStatus($task);

        return $taskStatus;
    }


    /**
     * Delete a subtask
     *
     * @param $id
     * @throws \Exception
     */
    public function destroy($id)
    {

        $subTask = SubTask::with('workDates.volunteers')->find($id);

        SubtaskService::delete($subTask);

        \Session::flash('flash_message', trans('entities/subtasks.deleted'));
        \Session::flash('flash_type', 'alert-success');

        return;
    }

}
