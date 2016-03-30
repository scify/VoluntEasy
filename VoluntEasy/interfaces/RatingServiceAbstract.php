<?php namespace Interfaces;

use App\Models\Action;
use App\Models\OPARating\InterpersonalSkill;
use App\Models\OPARating\LaborSkill;
use App\Models\Rating\ActionRating;
use App\Models\Rating\RatingAttribute;
use App\Models\User;
use App\Models\Volunteer;


/**
 * Class RatingServiceAbstract
 * @package Interfaces
 *
 * RatingServiceAbstract uses the Template method pattern in order to define
 * the basic functions needed for the crud operations, also offering some hooks
 * to implement non final functions.
 *
 * Public final functions define a general algorithm/behaviour for the whole class.
 * Public abstract function should be overriden in the classes that extend the Template.
 * Public functions have a default dehaviour and many be overriden by the classes that extend the Template.
 */
abstract class RatingServiceAbstract implements RatingInterface {

    public function hasCustomRatings(){
        return false;
    }

    public function rateVolunteers($token) {
        $actionRating = ActionRating::where('token', $token)->firstOrFail();
        $actionId = $actionRating->action_id;
        $action = Action::findOrFail($actionId);
        $user = User::findOrFail($actionRating->user_id);

        //first check if the user that requested the rating has already rated the action
        if (!$actionRating->rated) {

            //since the action has expired, and the volunteers are detached from it (a.k.a no rows at the pivot table)
            //we can easily retrieve the volunteers from the history tables
            $volunteers = Volunteer::whereHas('actionHistory', function ($q) use ($actionId) {
                $q->where('action_id', $actionId);
            })->get();

            $action->volunteers = $volunteers;

            $ratingAttributes = RatingAttribute::all();
            $actionRatingId = $actionRating->id;

            return view($this->getVolunteerRatingPage(), compact('user', 'action', 'ratingAttributes', 'actionRatingId'));
        } else {
            return view('main.ratings.volunteers_rated_already', compact('action'));
        }
    }


    abstract function getVolunteerRatingPage();

    abstract function storeVolunteerRating();


}
