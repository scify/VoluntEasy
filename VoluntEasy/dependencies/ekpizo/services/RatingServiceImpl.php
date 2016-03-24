<?php namespace Dependencies\ekpizo\services;


use App\Models\Action;
use App\Models\OPARating\InterpersonalSkill;
use App\Models\OPARating\LaborSkill;
use App\Models\Rating\ActionRating;
use App\Models\Rating\RatingAttribute;
use App\Models\User;
use App\Models\Volunteer;
use Interfaces\RatingServiceAbstract;

class RatingServiceImpl extends RatingServiceAbstract {

    private $folderName = 'ekpizo';


    public function rateVolunteers($token) {
        $actionRating = ActionRating::where('token', $token)->firstOrFail();
        $actionId = $actionRating->action_id;
        $action = Action::findOrFail($actionId);
        $user = User::findOrFail($actionRating->user_id);

        //first check if the user that requested the rating has already rated the action
        if (!$actionRating->rated) {

            //since the action has expired, and the volunteers are detached from it (a.k.a no rows at the pivot table)
            //we can easily retrieve the volunteers from the history tables
            $volunteers = Volunteer::with('workDateHistory.workDate.subtask.task')->whereHas('actionHistory', function ($q) use ($actionId) {
                $q->where('action_id', $actionId);
            })->get();

            $laborSkills = LaborSkill::all();
            $interpersonalSkills = InterpersonalSkill::all();

            $action->volunteers = $volunteers;

            $ratingAttributes = RatingAttribute::all();
            $actionRatingId = $actionRating->id;

            return view($this->getVolunteerRatingPage(), compact('user', 'action', 'laborSkills', 'interpersonalSkills', 'ratingAttributes', 'actionRatingId'));
        } else {
            return view('main.ratings.volunteers_rated_already', compact('action'));
        }
    }

    function getVolunteerRatingPage(){
        return $this->folderName.'.resources.views.ratings.rateVolunteers';
    }

    function storeVolunteerRating() {
        // TODO: Implement storeVolunteerRating() method.
    }
}
