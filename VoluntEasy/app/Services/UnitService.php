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

    /**
     * Get only the root of the tree
     *
     * @return mixed
     */
    public function getRoot()
    {
        $root = Unit::whereNull('parent_unit_id')->first();

        return $root;
    }


    /**
     * Get the whole tree oft he organization
     *
     * @return mixed
     */
    public function getTree()
    {
        $tree = Unit::whereNull('parent_unit_id')->with('allChildren')->first();

        return $tree;
    }



}
