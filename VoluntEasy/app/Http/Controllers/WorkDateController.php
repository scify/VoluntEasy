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

        /*
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


    private function saveVolunteers()
    {

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