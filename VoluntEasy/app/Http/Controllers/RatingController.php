<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Models\Action;
use App\Models\Rating\ActionRating;
use App\Models\Rating\Rating;
use App\Models\Rating\RatingAttribute;
use App\Models\Rating\VolunteerActionRating;
use App\Models\Volunteer;

class RatingController extends Controller {

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
    public function create($token) {

        $actionRating = ActionRating::where('token', $token)->firstOrFail();
        $actionId = $actionRating->action_id;
        $action = Action::findOrFail($actionId);

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

            return view('main.ratings.rate_volunteers', compact('action', 'ratingAttributes', 'actionRatingId'));
        } else {
            return view('main.ratings.rated_already', compact('action'));
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store() {
        $actionId = \Request::get('actionId');
        $actionRatingId = \Request::get('actionRatingId');
        $volunteers = \Request::get('volunteers');

        //for each volunteer, we have to create an entry to the
        //volunteer_action_ratings table
        foreach ($volunteers as $volunteer) {

            $volunteerActionRating = new VolunteerActionRating([
                'volunteer_id' => $volunteer['id'],
                'action_rating_id' => $actionRatingId,
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

    public function thankyou($actionId) {
        $action = Action::find($actionId);

        return view('main.ratings.thankyou', compact('action'));
    }

}
