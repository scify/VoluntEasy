<?php namespace App\Services;

use App\Models\Unit;

class UnitService
{


    /**
     * Get the type of each unit.
     * If parent_unit_id is null, we have a root.
     * If it has children, we have a branch.
     * Else we have a leaf.
     *
     * @param Unit $unit
     * @return string
     */
    public function type(Unit $unit)
    {
        if ($unit->parent_unit_id == null)
            return 'root';
        else if ($unit->parent_unit_id != null && $unit->allChildren != null && sizeof($unit->allChildren) > 0)
            return 'branch';
        else
            return 'leaf';
    }

    public function getRoot()
    {
        $root = Unit::whereNull('parent_unit_id')->get();

        return $root;
    }


    public function getTree()
    {
        $tree = Unit::whereNull('parent_unit_id')->with('allChildren')->first();

        return $tree;
    }

    /**
     * Create an array that includes only the user ids
     * of the users assigned to a unit.
     * Used in the front end, in order to display the currently assigned users.
     *
     * @param Unit $unit
     * @return array
     */
    public function userIds(Unit $unit)
    {
        $userIds = array();
        foreach ($unit->users as $user) {
            array_push($userIds, $user->id);
        }

        return $userIds;
    }

}
