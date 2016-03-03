<?php namespace App\Http\Controllers;


use App\Models\ActionTasks\WorkDate;

class WorkDateController extends Controller
{


    public function __construct()
    {
        $this->middleware('auth');
    }


    /**
     * Save the work dates and times and the assigned volunteers, if any
     *
     * @param $subTask
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

        $workDate = new WorkDate([
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
    public function update(){

        $workDate = WorkDate::find(\Request::get('workdateId'));

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

        return $workDate;
    }

    /**
     * Delete a workdate
     */
    public function destroy($id){
        $workDate = WorkDate::find($id);

        //TODO check if it has volunteers and cta volunteers;

        return;
    }


}
