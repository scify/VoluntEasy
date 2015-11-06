<?php namespace App\Http\Controllers;

use App\Models\Action;
use App\Models\Collaboration;
use App\Models\Volunteer;

/**
 * Holds all the functions necessary for the autocompletes etc
 *
 * Class SearchController
 * @package App\Http\Controllers
 */
class SearchController extends Controller {

    /**
     * City autocomplete
     *
     * @return mixed
     */
    public function city() {
        return Volunteer::distinct()->where('city', 'like', \Request::get('term') . '%')->lists('city')->all();
    }

    /**
     * Country autocomplete
     *
     * @return mixed
     */
    public function country() {
        return Volunteer::distinct()->where('country', 'like', \Request::get('term') . '%')->lists('country')->all();
    }

    /**
     * Action user autocomplete
     *
     * @return mixed
     */
    public function actionUser() {
        return Action::distinct()->where('name', 'like', \Request::get('term') . '%')->lists('name')->all();
    }

    /**
     * Collaboration type autocomplete
     *
     * @return mixed
     */
    public function collabType() {
        return Collaboration::distinct()->where('type', 'like', \Request::get('term') . '%')->lists('type')->all();
    }

}
