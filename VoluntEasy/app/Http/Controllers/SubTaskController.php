<?php namespace App\Http\Controllers;

use App\Models\ActionTasks\Status;
use App\Models\ActionTasks\SubTask;
use App\Models\ActionTasks\WorkDate;
use App\Models\Volunteer;

class SubTaskController extends Controller {


    public function __construct() {
        $this->middleware('auth');
    }


    /**
     * View a certain subtask
     *
     * @param $id
     * @return mixed
     */
    public function show($id) {
        $subTask = SubTask::with('workDates.volunteers', 'checklist.createdBy', 'checklist.updatedBy', 'workDates.ctaVolunteers')->findOrFail($id);

        foreach ($subTask->workDates as $date) {
            foreach ($date->ctaVolunteers as $cta) {
                if ($cta->isVolunteer)
                    $cta->volunteer = Volunteer::where('email', $cta->email)->with('units')->first();
            }
        }

        return $subTask;
    }

    /**
     * Store a subtask
     */
    public function store() {

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

        $this->saveWorkDates($subTask);
        $this->saveVolunteers($subTask);

        return $subTask;
    }

    /**
     * Update a subtask
     */
    public function update() {
        $subTask = SubTask::with('workDates')->find(\Request::get('subTaskId'));

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

        return $this->saveWorkDates($subTask);
        $this->saveVolunteers($subTask);

        return $subTask;
    }

    /**
     * Update a subtask's status
     */
    public function updateStatus() {

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
    public function destroy($id) {

        $subTask = SubTask::with('volunteers', 'workDates')->find($id);

        if (sizeof($subTask->volunteers) > 0) {
            \Session::flash('flash_message', 'Το subtask περιέχει εθελοντές και δεν μπορεί να διαγραφεί.');
            \Session::flash('flash_type', 'alert-danger');
            return;
        }

        foreach ($subTask->workDates as $workDate) {
            $workDate->delete();
        }

        $subTask->delete();

        \Session::flash('flash_message', 'Το subtask διαγράφηκε.');
        \Session::flash('flash_type', 'alert-success');

        return;
    }

    /**
     * Save the work dates and times and the assigned volunteers, if any
     *
     * @param $subTask
     * @return mixed
     */
    private function saveWorkDates($subTask) {

        $dateIds = [];

        foreach (\Request::get('workDates')['dates'] as $i => $date) {

            if ($date != null && $date != '' && \Request::get('workDates')['hourFrom'][$i] != '00:00' && \Request::get('workDates')['hourTo'][$i] != '00:00') {
                $workDate = WorkDate::find(\Request::get('workDates')['ids'][$i]);

                //check if the datetime exists already
                if ($workDate == null) {
                    $workDate = new WorkDate([
                        'from_date' => \Carbon::createFromFormat('d/m/Y', $date),
                        'subtask_id' => $subTask->id,
                        'from_hour' => \Request::get('workDates')['hourFrom'][$i],
                        'to_hour' => \Request::get('workDates')['hourTo'][$i],
                        'comments' => \Request::get('workDates')['comments'][$i],
                        'volunteer_sum' => \Request::get('workDates')['volunteerSum'][$i]
                    ]);

                    $workDate->save();
                } else {
                    $workDate->update([
                        'from_date' => \Carbon::createFromFormat('d/m/Y', $date),
                        'subtask_id' => $subTask->id,
                        'from_hour' => \Request::get('workDates')['hourFrom'][$i],
                        'to_hour' => \Request::get('workDates')['hourTo'][$i],
                        'comments' => \Request::get('workDates')['comments'][$i],
                        'volunteer_sum' => \Request::get('workDates')['volunteerSum'][$i]
                    ]);
                }

                array_push($dateIds, $workDate->id);
            }
        }

        WorkDate::where('subtask_id', $subTask->id)->whereNotIn('id', $dateIds)->delete();

        return $subTask;
    }


    private function saveVolunteers() {

        /*   if (\Request::has('subtaskVolunteers')) {
               $volunteers = [];
               foreach (\Request::get('subtaskVolunteers') as $volunteer) {
                   array_push($volunteers, $volunteer);
               }
               $subTask->volunteers()->sync($volunteers);
           } else
               $subTask->volunteers()->detach();
   */
    }

}
