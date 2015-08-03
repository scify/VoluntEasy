<?php namespace App\Services;

use App\Models\Action;
use App\Services\Facades\SearchService as Search;
use App\Services\Facades\UserService;

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

    ];


    public function prepareForDataTable($actions) {
        $userUnits = UserService::userUnits();

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
