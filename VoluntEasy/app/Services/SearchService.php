<?php namespace App\Services;

/**
 * Holds the extra stuff that are used by all search functions
 *
 * Class SearchService
 * @package App\Services
 */
class SearchService {

    /**
     * Array to hold all the dropdowns of the ui
     * @var array
     */
    private $dropDowns = ['marital_status_id', 'gender_id', 'education_level_id', 'unit_id', 'user_id', 'parent_unit_id', 'status_id', 'interest_id'];

    /**
     * Dropdowns have an extra option that acts as a placeholder and has id=0.
     * If the user hasn't selected anything, the placeholder is selected and
     * the value 0 is send to the server so we don't have to make a query.
     *
     * @param $value
     * @param $column
     * @return bool
     */
    public function notDropDown($value, $column) {
        if (in_array($column, $this->dropDowns) && $value == "0")
            return true;
    }

}
