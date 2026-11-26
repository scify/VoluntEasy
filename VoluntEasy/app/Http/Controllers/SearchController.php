<?php namespace App\Http\Controllers;

use App\Models\Action;
use App\Models\Descriptions\CollaborationType;
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
        return Volunteer::distinct()->where('city', 'like', \Request::get('term') . '%')->pluck('city')->all();
    }

    /**
     * Country autocomplete
     *
     * @return mixed
     */
    public function country() {
        return Volunteer::distinct()->where('country', 'like', \Request::get('term') . '%')->pluck('country')->all();
    }

    /**
     * Action user autocomplete
     *
     * @return mixed
     */
    public function actionUser() {
        return Action::distinct()->where('name', 'like', \Request::get('term') . '%')->pluck('name')->all();
    }

    /**
     * Collaboration type autocomplete
     *
     * @return mixed
     */
    public function collabType() {
        return CollaborationType::matching((string) \Request::get('term'))->pluck('description')->all();
    }

    /**
     * Volunteer first name autocomplete
     *
     * @return mixed
     */
    public function volunteerFirstName() {
        return Volunteer::distinct()->where('name', 'like', \Request::get('term') . '%')->pluck('name')->all();
    }

    /**
     * Volunteer last name autocomplete
     *
     * @return mixed
     */
    public function volunteerLastName() {
        return Volunteer::distinct()->where('last_name', 'like', \Request::get('term') . '%')->pluck('last_name')->all();
    }

    /**
     * Volunteer additional skills autocomplete
     *
     * @return mixed
     */
    public function volunteerAdditionalSkills() {
        return Volunteer::distinct()->where('additional_skills', 'like', '%' . \Request::get('term') . '%')->pluck('additional_skills')->all();
    }

    /**
     * Volunteer extra lang sautocomplete
     *
     * @return mixed
     */
    public function volunteerExtraLang() {
        return Volunteer::distinct()->where('extra_lang', 'like', '%' . \Request::get('term') . '%')->pluck('extra_lang')->all();
    }

    /**
     * Volunteer work descr autocomplete
     *
     * @return mixed
     */
    public function volunteerWorkDescription() {
        return Volunteer::distinct()->where('work_description', 'like', '%' . \Request::get('term') . '%')->pluck('work_description')->all();
    }

    /**
     * Volunteer specialty autocomplete
     *
     * @return mixed
     */
    public function volunteerSpecialty() {
        return Volunteer::distinct()->where('specialty', 'like', '%' . \Request::get('term') . '%')->pluck('specialty')->all();
    }

    /**
     * Volunteer department autocomplete
     *
     * @return mixed
     */
    public function volunteerDepartment() {
        return Volunteer::distinct()->where('department', 'like', '%' . \Request::get('term') . '%')->pluck('department')->all();
    }

    /**
     * Volunteer participationΑctions autocomplete
     *
     * @return mixed
     */
    public function volunteerParticipationΑctions() {
        return Volunteer::distinct()->where('participation_actions', 'like', '%' . \Request::get('term') . '%')->pluck('participation_actions')->all();
    }

    /**
     * Volunteer computerUsageComments autocomplete
     *
     * @return mixed
     */
    public function volunteerComputerUsageComments() {
        return Volunteer::distinct()->where('computer_usage_comments', 'like', '%' . \Request::get('term') . '%')->pluck('computer_usage_comments')->all();
    }
}
