<?php namespace App\Services;

use App\Models\Action;
use App\Services\Facades\SearchService as Search;

class ActionService{

    /**
     * This array holds the names of the filters that the user is able to search by.
     * Filters correspond to column names.
     * @var array
     */
    private $filters = [
        'description' => 'like%',
        'unit_id' => '=',

    ];


    /**
     * Dynamic search chains a lot of queries depending on the filters sent by the user.
     *
     * @return mixed
     */
    public function search() {

        $query = Action::select();

        foreach ($this->filters as $column => $filter) {
            if (\Input::has($column)) {
                $value = \Input::get($column);
                switch ($filter) {
                    case '=':
                        if (!Search::notDropDown($value, $column))
                            $query->where($column, '=', \Input::get($column));
                        break;
                    case 'like%':
                        $query->where($column, 'like', \Input::get($column) . '%');
                        break;
                    default:
                        break;
                }
            }
        }

        $result = $query->orderBy('description', 'ASC')->paginate(5);
        $result->setPath(\URL::to('/').'/actions');

        return $result;
    }

}
