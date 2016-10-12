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
        return Volunteer::distinct()->where('name', 'like', trim(\Request::get('term')) . '%')->lists('name')->all();
    }

    /**
     * Volunteer last name autocomplete
     *
     * @return mixed
     */
    public function volunteerLastName() {
        return Volunteer::distinct()->where('last_name', 'like', trim(\Request::get('term')) . '%')->lists('last_name')->all();
    }

    /**
     * Volunteer additional skills autocomplete
     *
     * @return mixed
     */
    public function volunteerAdditionalSkills() {
        return Volunteer::distinct()->where('additional_skills', 'like', '%' . trim(\Request::get('term')) . '%')->lists('additional_skills')->all();
    }

    /**
     * Volunteer extra lang sautocomplete
     *
     * @return mixed
     */
    public function volunteerExtraLang() {
        return Volunteer::distinct()->where('extra_lang', 'like', '%' . trim(\Request::get('term')) . '%')->lists('extra_lang')->all();
    }

    /**
     * Volunteer work descr autocomplete
     *
     * @return mixed
     */
    public function volunteerWorkDescription() {
        return Volunteer::distinct()->where('work_description', 'like', '%' . trim(\Request::get('term')) . '%')->lists('work_description')->all();
    }

    /**
     * Volunteer specialty autocomplete
     *
     * @return mixed
     */
    public function volunteerSpecialty() {
        return Volunteer::distinct()->where('specialty', 'like', '%' . trim(\Request::get('term')) . '%')->lists('specialty')->all();
    }

    /**
     * Volunteer department autocomplete
     *
     * @return mixed
     */
    public function volunteerDepartment() {
        return Volunteer::distinct()->where('department', 'like', '%' . trim(\Request::get('term')) . '%')->lists('department')->all();
    }

    /**
     * Volunteer participationΑctions autocomplete
     *
     * @return mixed
     */
    public function volunteerParticipationΑctions() {
        return Volunteer::distinct()->where('participation_actions', 'like', '%' . trim(\Request::get('term')) . '%')->lists('participation_actions')->all();
    }

    /**
     * Volunteer computerUsageComments autocomplete
     *
     * @return mixed
     */
    public function volunteerComputerUsageComments() {
        return Volunteer::distinct()->where('computer_usage_comments', 'like', '%' . \Request::get('term') . '%')->lists('computer_usage_comments')->all();
    }
}
