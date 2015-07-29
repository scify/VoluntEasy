<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Models\Action;
use App\Models\Rating;
use App\Models\RatingVolunteerAction;
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
    public function create($volunteerId, $actionId) {
        $action = Action::findOrFail($actionId);
        $volunteer = Volunteer::findOrFail($volunteerId);

        return view('main.ratings.rate', compact('action', 'volunteer'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store() {
        $actionId = \Request::get('actionId');
        $volunteerId = \Request::get('volunteerId');

        $atrr1 = \Request::get('attr1');
        $atrr2 = \Request::get('attr2');
        $atrr3 = \Request::get('attr3');

        $action = Action::findOrFail($actionId);

        $email = 'aa@aa.gr';


        $volRating = new RatingVolunteerAction([
            'volunteer_id' => $volunteerId,
            'action_id' => $actionId,
            'email' => $email,
            'attr1' => $atrr1,
            'attr2' => $atrr2,
            'attr3' => $atrr3,
        ]);

                $volRating->save();

        $rating = Rating::where('volunteer_id', $volunteerId)->first();

        if ($rating == null) {
            $rating = new Rating([
                'volunteer_id' => $volunteerId,
                'rating_attr1' => $atrr1,
                'rating_attr2' => $atrr2,
                'rating_attr3' => $atrr3,
                'rating_attr1_count' => 1,
                'rating_attr2_count' => 1,
                'rating_attr3_count' => 1,
            ]);

            $rating->save();
        } else {
            $rating->rating_attr1 += $atrr1;
            $rating->rating_attr2 += $atrr2;
            $rating->rating_attr3 += $atrr3;
            $rating->rating_attr1_count++;
            $rating->rating_attr2_count++;
            $rating->rating_attr3_count++;

            $rating->save();
        }

        return $rating;
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id) {
        //
    }

}
