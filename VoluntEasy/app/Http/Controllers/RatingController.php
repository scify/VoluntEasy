<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Models\Action;
use App\Models\Rating\Rating;
use App\Models\Rating\RatingAttribute;
use App\Models\Rating\VolunteerActionRating;

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
    public function create($actionId) {
        $action = Action::with('volunteers')->findOrFail($actionId);
        $ratingAttributes = RatingAttribute::all();
        return view('main.ratings.rate', compact('action', 'ratingAttributes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store() {

        $actionId = \Request::get('actionId');
        $email = \Request::get('email');
        $volunteers = \Request::get('volunteers');

        //return ($volunteers);

        //for each volunteer, we have to create an entry to the
        //volunteer_action_ratings table
        foreach($volunteers as $volunteer) {

            $volunteerActionRating = new VolunteerActionRating([
                'volunteer_id' => $volunteer['id'],
                'action_rating_id' => 2
            ]);

            $volunteerActionRating->save();

            //then for every rating attribute, we must save the rating
            foreach($volunteer['ratings'] as $rating){
                $rating = new Rating([
                    'rating' => $rating['rating'],
                    'rating_attribute_id' => $rating['attrId'],
                    'volunteer_action_rating_id' => $volunteerActionRating->id,
                ]);

                $rating->save();
            }
        }


        /*
        //TODO: remove this
        $email = 'aa@aa.gr';

        foreach ($volunteers as $volunteer) {
            //save the current rating to the db
            $volRating = new RatingVolunteerAction([
                'volunteer_id' => $volunteer['id'],
                'action_id' => $actionId,
                'email' => $email,
                'attr1' => $volunteer['attr1'],
                'attr2' => $volunteer['attr2'],
                'attr3' => $volunteer['attr3'],
            ]);

            $volRating->save();

            $rating = Rating::where('volunteer_id', $volunteer['id'])->first();

            //check if a rating row already exists for a volunteer
            //if it doesn't exist, create and save a new one
            if ($rating == null) {
                $rating = new Rating([
                    'volunteer_id' => $volunteer['id'],
                    'rating_attr1' => $volunteer['attr1'],
                    'rating_attr2' => $volunteer['attr2'],
                    'rating_attr3' => $volunteer['attr3'],
                    'rating_attr1_count' => 1,
                    'rating_attr2_count' => 1,
                    'rating_attr3_count' => 1,
                ]);
                $rating->save();

            } else {
                //if a rating row already exists, then add the rating to the rating sum
                //for each attribute and increment the count of the voters
                $rating->rating_attr1 += $volunteer['attr1'];
                $rating->rating_attr2 += $volunteer['attr2'];
                $rating->rating_attr3 += $volunteer['attr3'];
                $rating->rating_attr1_count++;
                $rating->rating_attr2_count++;
                $rating->rating_attr3_count++;

                $rating->save();
            }
        }

        */
        return $actionId;
    }

    public function thankyou($actionId) {
        $action = Action::find($actionId);

        return view('main.ratings.thankyou', compact('action'));
    }

}
