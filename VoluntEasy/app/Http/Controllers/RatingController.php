<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Models\Action;
use App\Models\Rating\ActionRating;
use App\Models\Rating\ActionRatingAttribute;
use App\Models\Rating\ActionRatingScore;
use App\Models\Rating\ActionScore;
use App\Models\Rating\Rating;
use App\Models\Rating\RatingAttribute;
use App\Models\Rating\VolunteerActionRating;
use App\Models\Volunteer;

class RatingController extends Controller {

    private $ratingService;

    public function __construct() {
        $this->ratingService = \App::make('Interfaces\RatingInterface');
    }


    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function rateVolunteers($token) {

        $actionRating = ActionRating::where('token', $token)->firstOrFail();

        if (!$actionRating->rated) {
            if ($this->ratingService->hasCustomRatings()) {
                return $this->ratingService->rateVolunteers($token);
            } else {
                $actionId = $actionRating->action_id;
                $action = Action::findOrFail($actionId);

                //first check if the user that requested the rating has already rated the action

                //since the action has expired, and the volunteers are detached from it (a.k.a no rows at the pivot table)
                //we can easily retrieve the volunteers from the history tables
                $volunteers = Volunteer::whereHas('actionHistory', function ($q) use ($actionId) {
                    $q->where('action_id', $actionId);
                })->get();

                $action->volunteers = $volunteers;

                $ratingAttributes = RatingAttribute::all();
                $actionRatingId = $actionRating->id;

                return view('main.ratings.rate_volunteers', compact('action', 'ratingAttributes', 'actionRatingId'));

            }
        } else {
            $actionId = $actionRating->action_id;
            $action = Action::findOrFail($actionId);
            return view('main.ratings.volunteers_rated_already', compact('action'));
        }
    }

    /**
     *
     * Show the form for rating an action
     *
     * @param $token
     * @return \Illuminate\View\View
     */
    public function rateAction($token) {

        $actionScore = ActionScore::where('token', $token)->firstOrFail();
        $actionId = $actionScore->action_id;
        $action = Action::findOrFail($actionId);

        //first check if the user that requested the rating has already rated the action
        if (!$actionScore->rated) {
            $attributes = ActionRatingAttribute::all();

            return view('main.ratings.rate_action', compact('action', 'attributes', 'actionScore'));
        } else {
            return view('main.ratings.action_rated_already', compact('action'));
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function storeVolunteersRating() {

        if ($this->ratingService->hasCustomRatings()) {
            $actionRating = ActionRating::find(\Request::get('actionRatingId'));
            $actionRating->update(['rated' => true]);
            return $this->ratingService->storeVolunteerRating();
        }
        else {
            $actionId = \Request::get('actionId');
            $actionRatingId = \Request::get('actionRatingId');
            $volunteers = \Request::get('volunteers');

            //for each volunteer, we have to create an entry to the
            //volunteer_action_ratings table
            foreach ($volunteers as $volunteer) {

                $volunteerActionRating = new VolunteerActionRating([
                    'volunteer_id' => $volunteer['id'],
                    'action_rating_id' => $actionRatingId,
                    'user_id' => \Auth::user()->id,
                    'comments' => $volunteer['comments'],
                    'hours' => intval($volunteer['hours']),
                    'minutes' => intval($volunteer['minutes']),
                ]);

                $volunteerActionRating->save();

                //then for every rating attribute, we must save the rating
                foreach ($volunteer['ratings'] as $rating) {
                    $rating = new Rating([
                        'rating' => $rating['rating'],
                        'rating_attribute_id' => $rating['attrId'],
                        'volunteer_action_rating_id' => $volunteerActionRating->id,
                    ]);

                    $rating->save();
                }
            }

            //set the action rating as rated
            $actionRating = ActionRating::find($actionRatingId);
            $actionRating->update(['rated' => true]);

            return $actionId;
        }
    }


    /**
     * Save an action rating
     * @return mixed
     */
    public function storeActionRating() {

        $actionId = \Request::get('actionId');
        $actionScoreId = \Request::get('actionScoreId');
        $ratings = \Request::get('ratings');

        //for each volunteer, we have to create an entry to the
        //volunteer_action_ratings table
        foreach ($ratings as $rating) {
            $actionRatingScore = new ActionRatingScore([
                'score' => $rating['score'],
                'attribute_id' => $rating['attrId'],
                'action_score_id' => $actionScoreId
            ]);
            $actionRatingScore->save();
        }

        //set the action rating as rated
        $actionScore = ActionScore::find($actionScoreId);
        $actionScore->update(['rated' => true, 'comments' => \Request::get('comments')]);

        return $actionId;
    }


    public function actionThankyou($actionId) {
        $action = Action::find($actionId);

        return view('main.ratings.action_thankyou', compact('action'));
    }

    public function volunteersThankyou($actionId) {
        $action = Action::find($actionId);

        return view('main.ratings.volunteers_thankyou', compact('action'));
    }

}
