<?php namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Facades\TreeService;
use App\Services\Facades\UnitService;

class TreeApiController extends Controller {


    public function tree() {

        $tree = TreeService::getTree();

        $tree = TreeService::setPermissions($tree);

        return $tree;

    }


}
