<?php namespace App\Http\Controllers;

use App\Models\ActionTasks\Status;
use App\Models\ActionTasks\SubTask;
use App\Models\ActionTasks\WorkDate;
use App\Models\ActionTasks\WorkDates;
use App\Models\ActionTasks\WorkHour;
use App\Models\ActionTasks\WorkHours;

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
        $subTask = SubTask::with('volunteers')->findOrFail($id);

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

        foreach (\Request::get('workDates')['dates'] as $i => $date) {

            $workDate = new WorkDate([
                'fromDate' => \Carbon::createFromFormat('d/m/Y', $date),
                'subtask_id' => $subTask->id
            ]);
            $workDate->save();

            $workHours = new WorkHour([
                'fromHour' => \Request::get('workDates')['hourFrom'][$i],
                'toHour' => \Request::get('workDates')['hourTo'][$i],
                'subtask_work_dates_id' => $workDate->id
            ]);

            $workHours->save();
        }

        if (\Request::has('subtaskVolunteers'))
            $subTask->volunteers()->sync(\Request::get('subtaskVolunteers'));

        return;
    }

    /**
     * Update a subtask
     */
    public function update()
    {

        $subTask = SubTask::find(\Request::get('subTaskId'));

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

        if (\Request::has('subtaskVolunteers')) {
            $volunteers = [];
            foreach (\Request::get('subtaskVolunteers') as $volunteer) {
                array_push($volunteers, $volunteer);
            }
            $subTask->volunteers()->sync($volunteers);
        } else
            $subTask->volunteers()->detach();

        return;
    }

    /**
     * Update a subtask's status
     */
    public function updateStatus()
    {

        $subTask = SubTask::find(\Request::get('subTaskId'));

        $status = Status::where('description', \Request::get('status'))->first()->id;
        $subTask->update(['status_id' => $status]);

        return;
    }


    /**
     * Delete a subtask
     *
     * @param $id
     * @throws \Exception
     */
    public function destroy($id)
    {

        $subTask = SubTask::with('volunteers')->find($id);

        if (sizeof($subTask->volunteers) > 0) {
            \Session::flash('flash_message', 'Το subtask περιέχει εθελοντές και δεν μπορεί να διαγραφεί.');
            \Session::flash('flash_type', 'alert-danger');
            return;
        }

        \Session::flash('flash_message', 'Το subtask διαγράφηκε.');
        \Session::flash('flash_type', 'alert-success');

        $subTask->delete();

        return;
    }

}
