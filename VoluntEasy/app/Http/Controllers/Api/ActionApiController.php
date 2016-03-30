<?php namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Action;
use App\Models\Rating\ActionRatingAttribute;
use App\Models\Rating\ActionScore;
use App\Models\Volunteer;
use App\Services\Facades\ActionService;
use App\Services\Facades\VolunteerService;

class ActionApiController extends Controller {

    public function all() {
        $actions = Action::with('unit', 'volunteers')->orderBy('end_date', 'desc')->get();

        $data = ActionService::prepareForDataTable($actions);

        return ["data" => $data];
    }

    public function volunteers($id) {
        $action = Action::find($id);

        //check if action has expired
        $now = date('Y-m-d');
        $endDate = \Carbon::parse(\Carbon::createFromFormat('d/m/Y', $action->end_date))->format('Y-m-d');
        $expired = false;
        if ($endDate < $now)
            $expired = true;

        //if the action is expired, get the volunteers from the history table
        if ($expired) {
            $volunteers = Volunteer::whereHas('actionHistory', function ($q) use ($id) {
                $q->where('action_id', $id);
            })->get();
        } else {
            $unitId = Action::findOrFail($id)->unit_id;

            $volunteers = Volunteer::whereHas('actions', function ($q) use ($id) {
                $q->where('action_id', $id);
            })->with(['units' => function ($query) use ($unitId) {
                $query->where('unit_id', $unitId);
            }])->get();
        }

        $data = [];
        foreach ($volunteers as $volunteer) {
            if (sizeof($volunteer->units) > 0) {
                $volunteer = VolunteerService::setStatusToUnits($volunteer);
                array_push($data, $volunteer);
            }
        }

        return ["data" => $data];
    }

    /**
     * Return the actions in a way that the calendar plugin
     * can display them.
     *
     * @return array
     */
    public function calendar() {

        $calendar = [];

        $actions = Action::with('volunteers', 'unit')->get();

        foreach ($actions as $action) {
            $tmp = ([
                'title' => $action->description,
                'start' => \Carbon::parse(\Carbon::createFromFormat('d/m/Y', $action->start_date))->format('Y-m-d'),
                'end' => \Carbon::parse(\Carbon::createFromFormat('d/m/Y', $action->end_date)->addDay())->format('Y-m-d'),
                'start_date' => $action->start_date,
                'end_date' => $action->end_date,
                'description' => $action->comments,
                'unit' => $action->unit->description,
                'name' => $action->name,
                'email' => $action->email,
                'phone_number' => $action->phone_number,
                'volunteers' => $action->volunteers->count()
            ]);

            array_push($calendar, $tmp);
        }

        return $calendar;

    }


    public function rating($id) {

        $ratings = ActionScore::where('action_id', $id)->with('ratings')->get();

        $attributes = ActionRatingAttribute::all()->lists('description')->all();

        $answers = [];

        //initialize answers array
        $answers[0] = [
            'name' => trans('entities/ratings.fullyDisagree') ,
            'data' => []];
        $answers[1] = [
            'name' => trans('entities/ratings.disagree'),
            'data' => []];
        $answers[2] = [
            'name' => trans('entities/ratings.neutral'),
            'data' => []];
        $answers[3] = [
            'name' => trans('entities/ratings.agree'),
            'data' => []];
        $answers[4] = [
            'name' => trans('entities/ratings.fullyAgree'),
            'data' => []];

        for($i=0; $i<sizeof($attributes); $i++) {
            array_push($answers[0]['data'], 0);
            array_push($answers[1]['data'], 0);
            array_push($answers[2]['data'], 0);
            array_push($answers[3]['data'], 0);
            array_push($answers[4]['data'], 0);
        }


        foreach ($ratings as $rating) {
            foreach ($rating->ratings as $score) {
                $answers[intval($score->score)+2]['data'][$score->attribute_id-1]++;
            }
        }

        return [
            'questions' => $attributes,
            'series' => $answers
        ];
    }

}
