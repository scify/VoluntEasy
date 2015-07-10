<?php namespace App\Services;

use App\Models\Unit;
use App\Services\Facades\SearchService as Search;

class UnitService {

    /**
     * This array holds the names of the filters that the user is able to search by.
     * Filters correspond to column names.
     * @var array
     */
    private $filters = [
        'description' => 'like%',
        'parent_unit_id' => '=',

    ];

    /**
     * Get the type of each unit.
     * If parent_unit_id is null, we have a root.
     * If it has children, we have a branch.
     * Else we have a leaf.
     *
     * @param Unit $unit
     * @return string
     */
    public function type(Unit $unit) {
        if ($unit->parent_unit_id == null)
            return 'root';
        else if ($unit->parent_unit_id != null && $unit->allChildren != null && sizeof($unit->allChildren) > 0)
            return 'branch';
        else
            return 'leaf';
    }

    /**
     * Get only the root of the tree
     *
     * @return mixed
     */
    public function getRoot() {
        $root = Unit::whereNull('parent_unit_id')->first();

        return $root;
    }


    /**
     * Get the whole tree oft he organization
     *
     * @return mixed
     */
    public function getTree() {
        $tree = Unit::whereNull('parent_unit_id')->with('allChildren')->first();

        return $tree;
    }


    /**
     * Dynamic search chains a lot of queries depending on the filters sent by the user.
     *
     * @return mixed
     */
    public function search() {

        $query = Unit::select();

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

        $result = $query->orderBy('description', 'ASC')->with('parent')->paginate(5);

        return $result;
    }


}
