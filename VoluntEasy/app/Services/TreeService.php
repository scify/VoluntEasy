<?php namespace App\Services;


use App\Models\Unit;
use App\Services\Facades\UserService as UserServiceFacade;

class TreeService {

    private $userUnits;

    public function __construct() {

        $this->userUnits = UserServiceFacade::userUnits();

    }

    public function getTree() {
        $tree = Unit::whereNull('parent_unit_id')->with('allActions', 'allChildren.allActions')->first();

        return $tree;
    }


    /**
     * Set the permissions for all the branches recursively.
     *
     * @param $parent
     * @return mixed
     */
    public function setPermissions($parent) {

        if (in_array($parent->id, $this->userUnits))
            $parent->permitted = true;
        else
            $parent->permitted = false;

        if (sizeof($parent->allChildren) > 0) {

            foreach ($parent->allChildren as $child) {
                if (in_array($child->id, $this->userUnits))
                    $child->permitted = true;
                else
                    $child->permitted = false;

                if (sizeof($child->allChildren) > 0)
                    $this->setPermissions($child);
            }
        }
        return $parent;
    }
}
