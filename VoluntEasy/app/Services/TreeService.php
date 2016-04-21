<?php namespace App\Services;


use App\Models\Unit;


class TreeService {

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
    public function setPermissions($parent, $userUnits) {

        if (in_array($parent->id, $userUnits))
            $parent->permitted = true;
        else
            $parent->permitted = false;

        foreach ($parent->allChildren as $child) {
            if (in_array($child->id, $userUnits))
                $child->permitted = true;
            else
                $child->permitted = false;

            if (sizeof($child->allChildren) > 0)
                $this->setPermissions($child, $userUnits);
        }
        return $parent;
    }

    public function setActives($userUnits, $parent, $active = null) {

        if ($active != null) {
            $parent->active = $active;
        } else {
            if (in_array($parent->id, $userUnits)) {
                $active = true;
                $parent->active = true;
            } else
                $parent->active = false;
        }

        foreach ($parent->allChildren as $child) {
            if ($active != null)
                $child->disabled = $active;
            else {
                if (in_array($child->id, $userUnits))
                    $child->active = true;
                else
                    $child->active = false;
            }
            if (sizeof($child->allChildren) > 0)
                $this->setActives($userUnits, $child, $active);
        }
        return $parent;


    }
}
