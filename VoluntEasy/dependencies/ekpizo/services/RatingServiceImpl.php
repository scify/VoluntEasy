<?php namespace Dependencies\ekpizo\services;


use App\Models\Action;
use App\Models\OPARating\InterpersonalSkill;
use App\Models\OPARating\LaborSkill;
use App\Models\OPARating\VolunteerInterpersonalSkill;
use App\Models\OPARating\VolunteerLaborSkill;
use App\Models\OPARating\VolunteerRating;
use App\Models\Rating\ActionRating;
use App\Models\Rating\RatingAttribute;
use App\Models\User;
use App\Models\Volunteer;
use Interfaces\RatingServiceAbstract;

class RatingServiceImpl extends RatingServiceAbstract {

    private $folderName = 'ekpizo';

    public function hasCustomRatings(){
        return true;
    }

    /* do stuff and return the path */
    public function rateVolunteers($token) {
        $actionRating = ActionRating::where('token', $token)->firstOrFail();
        $actionId = $actionRating->action_id;
        $action = Action::findOrFail($actionId);
        $user = User::findOrFail($actionRating->user_id);

        //first check if the user that requested the rating has already rated the action
        if (!$actionRating->rated) {

            //since the action has expired, and the volunteers are detached from it (a.k.a no rows at the pivot table)
            //we can easily retrieve the volunteers from the history tables
            $volunteers = Volunteer::with('shiftHistory.shift.trashedSubtask.trashedTask')->whereHas('actionHistory', function ($q) use ($actionId) {
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

    /* get the path of the view */
    function getVolunteerRatingPage() {
        return $this->folderName . '.resources.views.ratings.rateVolunteers';
    }

    /* store a volunteer rating*/
    function storeVolunteerRating() {

        $userId = \Request::get('user_id');
        $actionId = \Request::get('action_id');
        $actionRatingId = \Request::get('actionRatingId');

        foreach (\Request::get('volunteers') as $volunteer) {

            $volunteerOpaRating = new VolunteerRating([
                'actionDescription' => $volunteer['actionDescription'],
                'problemsOccured' => $volunteer['problemsOccured'],
                'training' => $volunteer['training'],
                'fieldsToImprove' => $volunteer['fieldsToImprove'],
                'objectives' => $volunteer['objectives'],
                'support' => $volunteer['support'],
                'generalComments' => $volunteer['generalComments'],
                'volunteer_id' => $volunteer['volunteer_id'],
                'user_id' => $userId,
                'action_id' => $actionId,
                'action_rating_id' => $actionRatingId,
            ]);
            $volunteerOpaRating->save();

            if (isset($volunteer['laborSkills'])) {
                foreach ($volunteer['laborSkills'] as $laborSkill) {

                    if (!isset($laborSkill['strongOrWeak']))
                        $laborSkill['strongOrWeak'] = -1;
                    if (!isset($laborSkill['comments']))
                        $laborSkill['comments'] = null;

                    VolunteerLaborSkill::create([
                        'comments' => $laborSkill['comments'],
                        'needsImprovement' => $laborSkill['strongOrWeak'],
                        'labor_skill_id' => $laborSkill['id'],
                        'opa_rating_id' => $volunteerOpaRating->id,
                    ]);
                }
            }

            if (isset($volunteer['interpersonalSkills'])) {
                foreach ($volunteer['interpersonalSkills'] as $interpersonalSkill) {

                    if (!isset($interpersonalSkill['strongOrWeak']))
                        $interpersonalSkill['strongOrWeak'] = -1;
                    if (!isset($interpersonalSkill['comments']))
                        $interpersonalSkill['comments'] = null;

                    VolunteerInterpersonalSkill::create([
                        'comments' => $interpersonalSkill['comments'],
                        'needsImprovement' => $interpersonalSkill['strongOrWeak'],
                        'intp_skill_id' => $interpersonalSkill['id'],
                        'opa_rating_id' => $volunteerOpaRating->id,
                    ]);
                }
            }
        }

        return $actionId;

    }


    function deleteRating($id){
        $rating = VolunteerRating::with('actionRating')->find($id);
        $rating->actionRating->update(['rated'=>false]);
        $rating->laborSkills()->delete();
        $rating->interpersonalSkills()->delete();
        $rating->delete();

        return;
    }
}
