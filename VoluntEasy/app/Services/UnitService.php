<?php namespace App\Services;

use App\Models\Unit;
use App\Models\Step as Step;
use App\Services\Facades\SearchService as Search;
use App\Services\Facades\UserService as UserServiceFacade;

class UnitService {

    /**
     * This array holds the names of the filters that the user is able to search by.
     * Filters correspond to column names.
     * If a filter doesn't have an operator, a special action is required.
     *
     * @var array
     */
    private $filters = [
        'description' => 'like%',
        'parent_unit_id' => '=',
        'user_id' => '',
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
     * Get an array with the current branch
     *
     * @param $unit
     * @return array
     */
    public function getBranch($unit) {
        $branchTmp = [];
        array_push($branchTmp, $unit);
        $curr = $unit->parent_unit_id;
        while ($curr != null) {
            $unit = Unit::where('id', $curr)->first();
            array_push($branchTmp, $unit);
            $curr = $unit->parent_unit_id;
        }

        $branchTmp = array_reverse($branchTmp);

        return $branchTmp;
    }


    /**
     * Get the whole tree of the organization
     *
     * @return mixed
     */
    public function getTree() {
        $tree = Unit::whereNull('parent_unit_id')->with('allChildren')->first();

        return $tree;
    }

    /**
     * When creating a new unit, automatically assign some predefined steps
     *
     * @return array
     */
    public function createSteps() {
        $steps = [
            new Step([
                'description' => 'Επικοινωνία με εθελοντή',
                'step_order' => 1,
                'type' => 'Communication'
            ]),
            new Step([
                'description' => 'Συνέντευξη με εθελοντή',
                'step_order' => 2,
                'type' => 'Interview'
            ]),
            new Step([
                'description' => 'Ανάθεση σε Μονάδα/Δράση',
                'step_order' => 3,
                'type' => 'Assignment'
            ])
        ];

        return $steps;
    }


    /**
     * Dynamic search chains a lot of queries depending on the filters sent by the user.
     *
     * @return mixed
     */
    public function search() {

        if (\Input::has('my_units')) {
            $userUnits = UserServiceFacade::userUnits();
            $query = Unit::whereIn('id', $userUnits);
        } else
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
                    case '':
                        switch ($column) {
                            case 'user_id':
                                if (!Search::notDropDown($value, $column)) {
                                    $id = \Input::get('user_id');
                                    $query->whereHas('users', function ($query) use ($id) {
                                        $query->where('id', $id);
                                    });
                                }
                                break;

                        }
                    default:
                        break;
                }
            }
        }

        $result = $query->orderBy('description', 'ASC')->with('parent')->paginate(5);
        $result->setPath(\URL::to('/') . '/units');

        return $result;
    }


}
