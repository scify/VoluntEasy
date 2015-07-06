<?php namespace App\Services;

use App\Models\Volunteer;
use App\Services\Facades\UnitService as UnitServiceFacade;

class VolunteerService {

    /**
     * This array holds the names of the filters that the user is able to search by.
     * Filters correspond to column names.
     * @var array
     */
    private $filters = [
        'name' => 'like%',
        'last_name' => 'like%',
        'email' => '=',
    ];

    /**
     * Get all the volunteers that are assigned to the root unit,
     * aka unassigned.
     *
     * @return mixed
     */
    public function getNew() {
        $root = UnitServiceFacade::getRoot();

        $volunteers = null;

        if ($root->count() > 0) {
            $volunteers = Volunteer::unit($root->id)->with('units.steps.status')->get();
        }

        return $volunteers;
    }


    /**
     * From a list of volunteers, get a list of ids.
     *
     * @param $volunteers
     * @return mixed
     */
    public function volunteerIds($volunteers) {
        $ids = [];

        foreach ($volunteers as $volunteer)
            array_push($ids, $volunteer->id);

        return $ids;
    }

    /**
     * Dynamic search chains a lot of queries depending on the filters sent by the user.
     *
     * @return mixed
     */
    public function search() {

        $query = Volunteer::select();

        foreach ($this->filters as $column => $filter) {
            if (\Input::has($column)) {
                switch ($filter) {
                    case '=':
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

        $result = $query->orderBy('name', 'ASC')->with('actions')->paginate(5);

        return $result;
    }

}
