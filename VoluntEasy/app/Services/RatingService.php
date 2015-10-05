<?php namespace App\Services;

use App\Models\Rating\RatingAttribute;

class RatingService {


    /**
     * Calculate the total rating for a volunteer.
     *
     * @param $timeline
     * @return array
     */
    public function totalVolunteerRating($timeline) {

        //get all rating attributes
        $ratingsAttrs = RatingAttribute::all();

        //initialize ratings array
        //totalRating keeps the sum of all ratings
        //and count keeps the number of people that have voted
        $ratings = [];
        foreach ($ratingsAttrs as $r) {
            $ratings[$r->id] = [
                'id' => $r->id,
                'description' => $r->description,
                'totalRating' => 0,
                'count' => 0,
            ];
        }

        foreach ($timeline as $block) {
            if ($block->type == 'action') {
                foreach ($block->action->ratings as $rating) {
                    foreach ($rating->volunteerRatings as $volRating) {
                        foreach ($volRating->ratings as $r) {
                            $ratings[$r->rating_attribute_id]['totalRating'] += $r->rating;
                            $ratings[$r->rating_attribute_id]['count']++;
                        }
                    }
                }
            }
        }

        return $ratings;
    }
}
