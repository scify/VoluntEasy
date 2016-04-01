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

    /**
     * Volunteer first name autocomplete
     *
     * @return mixed
     */
    public function volunteerFirstName() {
        return Volunteer::distinct()->where('name', 'like', \Request::get('term') . '%')->lists('name')->all();
    }

    /**
     * Volunteer last name autocomplete
     *
     * @return mixed
     */
    public function volunteerLastName() {
        return Volunteer::distinct()->where('last_name', 'like', \Request::get('term') . '%')->lists('last_name')->all();
    }

    /**
     * Volunteer additional skillsautocomplete
     *
     * @return mixed
     */
    public function volunteerAdditionalSkills() {
        return Volunteer::distinct()->where('additional_skills', 'like', '%' . \Request::get('term') . '%')->lists('additional_skills')->all();
    }

    /**
     * Volunteer additional skillsautocomplete
     *
     * @return mixed
     */
    public function volunteerExtraLang() {
        return Volunteer::distinct()->where('extra_lang', 'like', '%' . \Request::get('term') . '%')->lists('extra_lang')->all();
    }

    /**
     * Volunteer additional skillsautocomplete
     *
     * @return mixed
     */
    public function volunteerWorkDescription() {
        return Volunteer::distinct()->where('work_description', 'like', '%' . \Request::get('term') . '%')->lists('work_description')->all();
    }
}
