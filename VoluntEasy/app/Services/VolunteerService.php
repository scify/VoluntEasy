<?php namespace App\Services;

use App\Models\Volunteer;
use App\Services\Facades\SearchService as Search;
use App\Services\Facades\UnitService as UnitServiceFacade;

class VolunteerService {

    /**
     * This array holds the names of the filters that the user is able to search by.
     * Filters correspond to column names.
     * @var array
     */
    //private $filters = [ 'name', 'last_name', 'email', 'marital_status_id' ];
    private $filters = [
        'name' => 'like%',
        'last_name' => 'like%',
        'email' => '=',
        'marital_status_id' => '=',
        'gender_id' => '=',
        'city' => '=',
        'country' => '=',
        'age-range' => '',
        'phoneNumber' => '',
        'education_level_id' => '=',
        'unit_id' => '',

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

        //dd(\Input::all());

        foreach ($this->filters as $column => $filter) {
            if (\Input::has($column) && \Input::get($column) != "") {
                $value = \Input::get($column);
                switch ($filter) {
                    case '=':
                        if (!Search::notDropDown($value, $column))
                            $query->where($column, '=', $value);
                        break;
                    case 'like%':
                        $query->where($column, 'like', $value . '%');
                        break;
                    case '':
                        switch ($column) {
                            case 'age-range':
                                $ages = explode("-", $value);

                                $date = date('Y-m-d');
                                $newdate = strtotime('-' . $ages[0] . ' year', strtotime($date));
                                $ages[0] = date('Y-m-j', $newdate);
                                $date = date('Y-m-d');
                                $newdate = strtotime('-' . $ages[1] . ' year', strtotime($date));
                                $ages[1] = date('Y-m-j', $newdate);

                                $query->whereBetween('birth_date', [$ages[1], $ages[0]]);
                                break;
                            case 'phoneNumber':
                                $query->where('home_tel', \Input::get('phoneNumber'))
                                    ->orWhere('work_tel', \Input::get('phoneNumber'))
                                    ->orWhere('cell_tel', \Input::get('phoneNumber'));
                            case 'unit_id':
                                if (!Search::notDropDown($value, $column)) {
                                    $id = \Input::get('unit_id');
                                    $query->whereHas('units', function ($query) use ($id) {
                                        $query->where('id', $id);
                                    });
                                }
                        }
                    default:
                        //  dd('default switch');
                        break;
                }
            }
        }
        $result = $query->orderBy('name', 'ASC')->with('actions')->paginate(5);

        // dd($query);

        return $result;
    }

}
