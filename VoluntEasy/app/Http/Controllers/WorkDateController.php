<?php namespace App\Http\Controllers;


use App\Models\Action;
use App\Models\ActionTasks\SubtaskWorkDate;
use App\Models\Volunteer;
use App\Models\VolunteerWorkDateHistory;
use App\Services\Facades\VolunteerService;
use App\Services\Facades\WorkDateService;

class WorkDateController extends Controller
{


    public function __construct()
    {
        $this->middleware('auth');
    }


    /**
     * Save the work dates and times and the assigned volunteers, if any
     *
     * @return mixed
     */
    public function store()
    {
        $dateFrom = null;
        $from_hour = null;
        $to_hour = null;
        if (\Request::has('dateFrom') && \Request::get('dateFrom') != null && \Request::get('dateFrom') != '')
            $dateFrom = \Carbon::createFromFormat('d/m/Y', \Request::get('dateFrom'));
        if (\Request::has('hourFrom') && \Request::get('hourFrom') != null && \Request::get('hourFrom') != '')
            $from_hour = \Request::get('hourFrom');
        if (\Request::has('hourTo') && \Request::get('hourTo') != null && \Request::get('hourTo') != '')
            $to_hour = \Request::get('hourTo');

        $workDate = new SubtaskWorkDate([
            'from_date' => $dateFrom,
            'subtask_id' => \Request::get('subtaskId'),
            'from_hour' => $from_hour,
            'to_hour' => $to_hour,
            'comments' => \Request::get('comments'),
            'volunteer_sum' => \Request::get('volunteerSum')
        ]);

        $workDate->save();

        return $workDate;
    }

    /*
     * Update the workdate
     */
    public function update()
    {

        //fetch the workdate with the volunteers
        $workDate = SubtaskWorkDate::with('volunteers')->find(\Request::get('workdateId'));

        $dateFrom = null;
        $from_hour = null;
        $to_hour = null;
        if (\Request::has('dateFrom') && \Request::get('dateFrom') != null && \Request::get('dateFrom') != '')
            $dateFrom = \Carbon::createFromFormat('d/m/Y', \Request::get('dateFrom'));
        if (\Request::has('hourFrom') && \Request::get('hourFrom') != null && \Request::get('hourFrom') != '')
            $from_hour = \Request::get('hourFrom');
        if (\Request::has('hourTo') && \Request::get('hourTo') != null && \Request::get('hourTo') != '')
            $to_hour = \Request::get('hourTo');

        $workDate->update([
            'from_date' => $dateFrom,
            'from_hour' => $from_hour,
            'to_hour' => $to_hour,
            'comments' => \Request::get('comments'),
            'volunteer_sum' => \Request::get('volunteerSum')
        ]);

        $newVolunteers = [];
        if (\Request::has('volunteers') && \Request::get('volunteers') != '') {
            $newVolunteers = explode(',', \Request::get('volunteers'));
        }

        $action = Action::find(\Request::get('action_id'));

        //remove all the current volunteers
        foreach ($workDate->volunteers as $volunteer) {
            $volunteer->workDates()->detach([$workDate->id]);
            VolunteerService::removeFromAction($volunteer, $action);
        }

        //add the volunteers to the action
        WorkDateService::addVolunteersToAction($newVolunteers, $workDate->id, $action);

        $workDate->volunteers()->sync($newVolunteers);

        return $workDate;
    }

    /**
     * Delete a workdate
     */
    public function destroy($id)
    {
        $workDate = SubtaskWorkDate::with('volunteers.actions', 'ctaVolunteers')->find($id);

        WorkDateService::delete($workDate);

        return;
    }



}
