<?php namespace App\Services;


use App\Models\Action;
use App\Services\Facades\VolunteerService;

class WorkDateService {

    /**
     * Delete a workDate and dissociate any volunteers attached
     *
     * @param $workDate
     */
    public function delete($workDate) {
        $action = Action::find(\Request::get('action_id'));

        //remove the volunteers from the action
        foreach ($workDate->volunteers as $volunteer) {
            $volunteer->workDates()->detach();
            VolunteerService::removeFromAction($volunteer, $action);
        }

        $workDate->subtask()->dissociate();
        $workDate->ctaVolunteers()->detach();
        $workDate->delete();

        return;
    }
}
