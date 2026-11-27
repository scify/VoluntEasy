<?php namespace App\Http\Controllers;

use App\Models\Action;
use App\Services\Volunteers\VolunteerAssignment;
use App\Models\ActionTasks\SubtaskShift;
use App\Services\Facades\ShiftService;
use App\Services\Facades\VolunteerService;

class SubtaskShiftController extends Controller
{

    private VolunteerAssignment $volunteerAssignment;

    public function __construct(VolunteerAssignment $volunteerAssignment) {
        $this->volunteerAssignment = $volunteerAssignment;
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
        if (\Request::filled('dateFrom') && \Request::get('dateFrom') != null && \Request::get('dateFrom') != '')
            $dateFrom = \Carbon::createFromFormat('d/m/Y', \Request::get('dateFrom'));
        if (\Request::filled('hourFrom') && \Request::get('hourFrom') != null && \Request::get('hourFrom') != '')
            $from_hour = \Request::get('hourFrom');
        if (\Request::filled('hourTo') && \Request::get('hourTo') != null && \Request::get('hourTo') != '')
            $to_hour = \Request::get('hourTo');

        $shift = new SubtaskShift([
            'from_date' => $dateFrom,
            'subtask_id' => \Request::get('subtaskId'),
            'from_hour' => $from_hour,
            'to_hour' => $to_hour,
            'comments' => \Request::get('comments'),
            'volunteer_sum' => \Request::get('volunteerSum')
        ]);

        $shift->save();

        return $shift;
    }

    /*
     * Update the shift
     */
    public function update()
    {

        //fetch the shifts with the volunteers
        $shift = SubtaskShift::with('volunteers')->find(\Request::get('shiftId'));

        $dateFrom = null;
        $from_hour = null;
        $to_hour = null;
        if (\Request::filled('dateFrom') && \Request::get('dateFrom') != null && \Request::get('dateFrom') != '')
            $dateFrom = \Carbon::createFromFormat('d/m/Y', \Request::get('dateFrom'));
        if (\Request::filled('hourFrom') && \Request::get('hourFrom') != null && \Request::get('hourFrom') != '')
            $from_hour = \Request::get('hourFrom');
        if (\Request::filled('hourTo') && \Request::get('hourTo') != null && \Request::get('hourTo') != '')
            $to_hour = \Request::get('hourTo');

        $shift->update([
            'from_date' => $dateFrom,
            'from_hour' => $from_hour,
            'to_hour' => $to_hour,
            'comments' => \Request::get('comments'),
            'volunteer_sum' => \Request::get('volunteerSum')
        ]);

        $newVolunteers = [];
        if (\Request::filled('volunteers') && \Request::get('volunteers') != '') {
            $newVolunteers = explode(',', \Request::get('volunteers'));
        }

        $action = Action::find(\Request::get('action_id'));

        //remove all the current volunteers
        foreach ($shift->volunteers as $volunteer) {
            $volunteer->subtaskShifts()->detach([$shift->id]);
            $this->volunteerAssignment->removeFromAction($volunteer, $action);
        }

        //add the volunteers to the action
        ShiftService::addVolunteersToSubtask($newVolunteers, $shift->id, $action);

        $shift->volunteers()->sync($newVolunteers);

        return $shift;
    }

    /**
     * Delete a shift
     */
    public function destroy($id)
    {
        $shift = SubtaskShift::with('volunteers.actions', 'ctaVolunteers')->find($id);

        ShiftService::deleteSubtaskShift($shift);

        return;
    }

}
