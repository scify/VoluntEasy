<?php namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\Facades\TreeService;
use App\Services\Facades\UserService;

class TreeApiController extends Controller {


    public function tree() {

        $tree = TreeService::getTree();
        $userUnits = UserService::userUnits();
        $tree = TreeService::setPermissions($tree, $userUnits);

        return $tree;
    }

    public function activeUnits($id) {

        $user = User::with('units')->findOrFail($id);

        $tree = TreeService::getTree();

        $tree = TreeService::setPermissions($tree);

        $tree = TreeService::setActives($user->units->lists('id')->all(), $tree);

        return $tree;
    }

}
