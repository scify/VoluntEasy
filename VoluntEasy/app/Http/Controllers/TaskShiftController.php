<?php

namespace App\Http\Controllers;

use App\Models\Action;
use App\Models\ActionTasks\TaskShift;
use App\Services\ShiftService;
use App\Services\Volunteers\VolunteerAssignment;

class TaskShiftController extends Controller
{
    private ShiftService $shiftService;

    private VolunteerAssignment $volunteerAssignment;

    public function __construct(VolunteerAssignment $volunteerAssignment, ShiftService $shiftService)
    {
        $this->shiftService = $shiftService;
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
        if (\Request::filled('dateFrom') && \Request::get('dateFrom') != null && \Request::get('dateFrom') != '') {
            $dateFrom = \Carbon::createFromFormat('d/m/Y', \Request::get('dateFrom'));
        }
        if (\Request::filled('hourFrom') && \Request::get('hourFrom') != null && \Request::get('hourFrom') != '') {
            $from_hour = \Request::get('hourFrom');
        }
        if (\Request::filled('hourTo') && \Request::get('hourTo') != null && \Request::get('hourTo') != '') {
            $to_hour = \Request::get('hourTo');
        }

        $shift = new TaskShift([
            'from_date' => $dateFrom,
            'task_id' => \Request::get('taskId'),
            'from_hour' => $from_hour,
            'to_hour' => $to_hour,
            'comments' => \Request::get('comments'),
            'volunteer_sum' => \Request::get('volunteerSum'),
        ]);

        $shift->save();

        return $shift;
    }

    /*
     * Update the shift
     */
    public function update()
    {

        // fetch the shifts with the volunteers
        $shift = TaskShift::with('volunteers')->find(\Request::get('shiftId'));

        $dateFrom = null;
        $from_hour = null;
        $to_hour = null;
        if (\Request::filled('dateFrom') && \Request::get('dateFrom') != null && \Request::get('dateFrom') != '') {
            $dateFrom = \Carbon::createFromFormat('d/m/Y', \Request::get('dateFrom'));
        }
        if (\Request::filled('hourFrom') && \Request::get('hourFrom') != null && \Request::get('hourFrom') != '') {
            $from_hour = \Request::get('hourFrom');
        }
        if (\Request::filled('hourTo') && \Request::get('hourTo') != null && \Request::get('hourTo') != '') {
            $to_hour = \Request::get('hourTo');
        }

        $shift->update([
            'from_date' => $dateFrom,
            'from_hour' => $from_hour,
            'to_hour' => $to_hour,
            'comments' => \Request::get('comments'),
            'volunteer_sum' => \Request::get('volunteerSum'),
        ]);

        $newVolunteers = [];
        if (\Request::filled('volunteers') && \Request::get('volunteers') != '') {
            $newVolunteers = explode(',', \Request::get('volunteers'));
        }

        $action = Action::find(\Request::get('action_id'));

        // remove all the current volunteers
        foreach ($shift->volunteers as $volunteer) {
            $volunteer->taskShifts()->detach([$shift->id]);
            $this->volunteerAssignment->removeFromAction($volunteer, $action);
        }

        // add the volunteers to the action
        $this->shiftService->addVolunteersToTask($newVolunteers, $shift->id, $action);

        $shift->volunteers()->sync($newVolunteers);

        return $shift;
    }

    /**
     * Delete a shift
     */
    public function destroy($id)
    {
        $shift = TaskShift::with('volunteers.actions', 'ctaVolunteers')->find($id);

        $this->shiftService->deleteTaskShift($shift);

    }
}
