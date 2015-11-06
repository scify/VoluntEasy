<?php namespace App\Services;

use App\Models\Action;
use App\Models\Rating\ActionRatingAttribute;
use App\Models\Rating\ActionScore;
use App\Services\Facades\SearchService as Search;
use App\Services\Facades\UserService as UserServiceFacade;

class ActionService {

    /**
     * This array holds the names of the filters that the user is able to search by.
     * Filters correspond to column names.
     * @var array
     */
    private $filters = [
        'description' => 'like%',
        'unit_id' => '=',
        'start_date' => '>',
        'end_date' => '<',
        'active_only' => '',
        'name' => '=',
    ];

    public function actionTotalRatings($id){

        $ratings = ActionScore::where('action_id', $id)->with('ratings')->get();

        $attributes = ActionRatingAttribute::all()->lists('description', 'id')->all();

        $totalRating = [];

        foreach($ratings as $rating){
            foreach($rating->ratings as $score){
                if(!isset($totalRating[$score->attribute_id])){
                    $totalRating[$score->attribute_id]['id'] = $score->attribute_id;
                    $totalRating[$score->attribute_id]['description'] = $attributes[$score->attribute_id];
                    $totalRating[$score->attribute_id]['score'] = $score->score;
                    $totalRating[$score->attribute_id]['count'] = 1;
                }
                else{
                    $totalRating[$score->attribute_id]['score'] += $score->score;
                    $totalRating[$score->attribute_id]['count'] ++;
                }
            }
        }
        return $totalRating;
    }



    public function prepareForDataTable($actions) {
        $userUnits = UserServiceFacade::userUnits();

        foreach ($actions as $action) {
            if (in_array($action->unit->id, $userUnits))
                $action->permitted = true;
            else
                $action->permitted = false;
        }
        return $actions;
    }


    /**
     * Dynamic search chains a lot of queries depending on the filters sent by the user.
     *
     * @return mixed
     */
    public function search() {

        $query = Action::select();

        //dd(\Input::all());

        foreach ($this->filters as $column => $filter) {
            if (\Input::has($column)) {
                $value = \Input::get($column);
                switch ($filter) {
                    case '=':
                        if (!Search::notDropDown($value, $column))
                            $query->where($column, '=', $value);
                        break;
                    case 'like%':
                        $query->where($column, 'like', $value . '%');
                        break;
                    case '>':
                        //operator used only for dates
                        $value = str_replace('/', '-', $value);
                        $value = date("Y-m-d", strtotime($value));
                        $query->where($column, '>', $value);
                        break;
                    case '<':
                        //operator used only for dates
                        $value = str_replace('/', '-', $value);
                        $value = date("Y-m-d", strtotime($value));
                        $query->where($column, '<', $value);
                        break;
                    case '':
                        switch ($column) {
                            case 'active_only':
                                $now = date('Y-m-d');
                                $query->where('end_date', '>=', $now);
                                break;
                        }
                    default:
                        break;
                }
            }
        }

        $result = $query->orderBy('description', 'ASC')->get();

        $data = $this->prepareForDataTable($result);

        return ["data" => $data];
    }

}
