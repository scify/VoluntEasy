<?php namespace App\Http\Controllers;

use App\Models\ActionTasks\Status;
use App\Models\ActionTasks\SubTask;
use App\Models\ActionTasks\Task;
use App\Models\Volunteer;
class SubTaskController extends Controller
{

    private \App\Services\SubtaskService $subtaskService;
    private \App\Services\TaskService $taskService;
    private \App\Services\VolunteerService $volunteerService;

    public function __construct(\App\Services\SubtaskService $subtaskService, \App\Services\TaskService $taskService, \App\Services\VolunteerService $volunteerService) {
        $this->subtaskService = $subtaskService;
        $this->taskService = $taskService;
        $this->volunteerService = $volunteerService;
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
        $subTask = SubTask::with('users', 'volunteers', 'shifts.volunteers', 'checklist.createdBy', 'checklist.updatedBy', 'shifts.ctaVolunteers.volunteer', 'action')->findOrFail($id);

        $subTask->unitVolunteers = $this->volunteerService->getAvailableUnitVolunteers($subTask->action->unit_id);

        //check if cta volunteer already exists in db, based on the email
        foreach ($subTask->shifts as $i => $date) {
            foreach ($date->ctaVolunteers as $j => $cta) {
                //volunteer is already assigned to a profile
                if (sizeof($cta->volunteer) > 0) {
                    foreach ($subTask->unitVolunteers as $k => $uv) {
                        //return $uv['id'];
                        if ($uv['id'] == $cta->volunteer[0]->id)
                            unset($subTask->shifts[$i]->ctaVolunteers[$j]);

                    }
                } else {
                    $cta->mightBe = Volunteer::where('email', $cta->email)->first();
                }
            }

        }

        unset($subTask->action);

        return $subTask;
    }

    /**
     * Store a subtask
     */
    public function store()
    {

        $todo = Status::todo();

        if (\Request::filled('subtask-due_date'))
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

        $this->subtaskService->syncUsers($subTask);
        $this->subtaskService->syncVolunteers($subTask);

        return $subTask;
    }

    /**
     * Update a subtask
     */
    public function update()
    {
        $subTask = SubTask::with('shifts')->find(\Request::get('subTaskId'));

        if (\Request::filled('subtask-due_date'))
            $due_date = \Carbon::createFromFormat('d/m/Y', \Request::get('subtask-due_date'));
        else
            $due_date = null;

        $subTask->update([
            'name' => \Request::get('subtask-name'),
            'description' => \Request::get('subtask-description'),
            'priority' => \Request::get('subtask-priorities'),
            'due_date' => $due_date
        ]);

        $this->subtaskService->syncUsers($subTask);
        $this->subtaskService->syncVolunteers($subTask);

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

        $taskStatus = $this->taskService->taskStatus($task);

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

        $subTask = SubTask::with('shifts.volunteers')->find($id);

        $this->subtaskService->delete($subTask);

        \Session::flash('flash_message', trans('entities/subtasks.deleted'));
        \Session::flash('flash_type', 'alert-success');

        return;
    }

}
