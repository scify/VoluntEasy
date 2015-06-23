<?php namespace App\Services;

use App\Models\Unit;

class UnitService
{


    public function type($id)
    {
        if ($id == null)
            return 'root';
        else
            return 'branch';
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


}