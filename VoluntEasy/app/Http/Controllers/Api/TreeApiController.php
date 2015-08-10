<?php namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Facades\UnitService;

class TreeApiController extends Controller {


    public function tree() {

        $tree = UnitService::getTree();

        return $tree;

    }

}
