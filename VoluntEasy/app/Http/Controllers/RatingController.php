<?php

namespace App\Http\Controllers;

use App\Models\Action;
use App\Models\Rating\ActionRating;
use App\Models\Rating\ActionRatingAttribute;
use App\Models\Rating\ActionRatingScore;
use App\Models\Rating\ActionScore;
use App\Models\Rating\Rating;
use App\Models\Rating\RatingAttribute;
use App\Models\Rating\VolunteerActionRating;
use App\Models\Volunteer;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Interfaces\RatingInterface;

class RatingController extends Controller
{
    private $ratingService;

    public function __construct(RatingInterface $ratingService)
    {
        $this->ratingService = $ratingService;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function rateVolunteers($token)
    {

        $actionRating = ActionRating::where('token', $token)->firstOrFail();

        if (! $actionRating->rated) {
            if ($this->ratingService->hasCustomRatings()) {
                return $this->ratingService->rateVolunteers($token);
            } else {
                $actionId = $actionRating->action_id;
                $action = Action::findOrFail($actionId);

                // first check if the user that requested the rating has already rated the action

                // since the action has expired, and the volunteers are detached from it (a.k.a no rows at the pivot table)
                // we can easily retrieve the volunteers from the history tables
                $volunteers = Volunteer::whereHas('actionHistory', function ($q) use ($actionId) {
                    $q->where('action_id', $actionId);
                })->get();

                $action->setRelation('volunteers', $volunteers);

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
     * Show the form for rating an action
     *
     * @return View
     */
    public function rateAction($token)
    {

        $actionScore = ActionScore::where('token', $token)->firstOrFail();
        $actionId = $actionScore->action_id;
        $action = Action::findOrFail($actionId);

        // first check if the user that requested the rating has already rated the action
        if (! $actionScore->rated) {
            $attributes = ActionRatingAttribute::all();

            return view('main.ratings.rate_action', compact('action', 'attributes', 'actionScore'));
        } else {
            return view('main.ratings.action_rated_already', compact('action'));
        }
    }

    /**
     * Store the ratings of the volunteers of an action (public page, reached
     * with the token of an e-mail). The rating, the action and the user come
     * from the token, never from the request; a token is used once.
     */
    public function storeVolunteersRating(Request $request)
    {
        $actionRating = ActionRating::where('token', (string) $request->input('token'))
            ->where('rated', false)->firstOrFail();
        $request->merge([
            'actionRatingId' => $actionRating->id,
            'actionId' => $actionRating->action_id,
            'action_id' => $actionRating->action_id,
            'user_id' => $actionRating->user_id,
        ]);

        if ($this->ratingService->hasCustomRatings()) {
            $actionRating->update(['rated' => true]);

            return $this->ratingService->storeVolunteerRating();
        }

        // for each volunteer, an entry in the volunteer_action_ratings table
        // and one rating per rating attribute
        foreach ((array) $request->input('volunteers', []) as $volunteer) {
            $volunteerActionRating = new VolunteerActionRating([
                'volunteer_id' => $volunteer['id'],
                'action_rating_id' => $actionRating->id,
                'user_id' => $actionRating->user_id,
                'comments' => $volunteer['comments'] ?? '',
                'hours' => intval($volunteer['hours'] ?? 0),
                'minutes' => intval($volunteer['minutes'] ?? 0),
            ]);
            $volunteerActionRating->save();

            foreach ($volunteer['ratings'] ?? [] as $rating) {
                (new Rating([
                    'rating' => $rating['rating'],
                    'rating_attribute_id' => $rating['attrId'],
                    'volunteer_action_rating_id' => $volunteerActionRating->id,
                ]))->save();
            }
        }

        $actionRating->update(['rated' => true]);

        return $actionRating->action_id;
    }

    /**
     * Store a volunteer's rating of an action (public page, reached with the
     * token of an e-mail; a token is used once).
     */
    public function storeActionRating(Request $request)
    {
        $actionScore = ActionScore::where('token', (string) $request->input('token'))
            ->where('rated', false)->firstOrFail();

        foreach ((array) $request->input('ratings', []) as $rating) {
            (new ActionRatingScore([
                'score' => $rating['score'],
                'attribute_id' => $rating['attrId'],
                'action_score_id' => $actionScore->id,
            ]))->save();
        }

        $actionScore->update(['rated' => true, 'comments' => $request->input('comments')]);

        return $actionScore->action_id;
    }

    public function actionThankyou($actionId)
    {
        $action = Action::find($actionId);

        return view('main.ratings.action_thankyou', compact('action'));
    }

    public function volunteersThankyou($actionId)
    {
        $action = Action::find($actionId);

        return view('main.ratings.volunteers_thankyou', compact('action'));
    }

    public function deleteVolunteerRating($id)
    {
        return $this->ratingService->deleteRating($id);
    }
}
