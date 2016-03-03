<?php namespace App\Http\Controllers;

use App\Models\ActionTasks\Status;
use App\Models\ActionTasks\SubTask;
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
        $subTask = SubTask::with('workDates.volunteers', 'checklist.createdBy', 'checklist.updatedBy', 'workDates.ctaVolunteers.volunteer', 'action')->findOrFail($id);

        $unitId = $subTask->action->unit_id;
        //get all volunteers to show in select box
        //those should be the volunteers that belong to the same unit
        //that the action belongs to
        $unitVolunteers = Volunteer::whereHas('units', function ($query) use ($unitId) {
            $query->where('unit_id', $unitId);
        })->orderBy('name', 'asc')->get()->toArray();


        //check if cta volunteer already exists in db, based on the email
        foreach ($subTask->workDates as $i => $date) {
            foreach ($date->ctaVolunteers as $j=> $cta) {

                if ($cta->isVolunteer == 1 && sizeof($cta->volunteer) > 0) {
                    foreach ($unitVolunteers as $k => $uv) {
                        //return $uv['id'];
                        if ($uv['id'] == $cta->volunteer[0]->id)
                            unset($subTask->workDates[$i]->ctaVolunteers[$j]);


                        //if the volunteer is already assigned to the work date, remove from the array
                        foreach($date->volunteers as $volunteer){
                                if($uv['id']==$volunteer->id){
                                    unset($unitVolunteers[$k]);
                                }
                        }
                    }
                } else if ($cta->isVolunteer == 1 && sizeof($cta->volunteer) == 0) {
                    $cta->mightBe = Volunteer::where('email', $cta->email)->first()->id;
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

}
