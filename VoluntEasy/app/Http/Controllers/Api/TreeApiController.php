<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\TreeService;
use App\Services\UserService;

class TreeApiController extends Controller
{
    private TreeService $treeService;

    private UserService $userService;

    public function __construct(TreeService $treeService, UserService $userService)
    {
        $this->treeService = $treeService;
        $this->userService = $userService;
    }

    public function tree()
    {

        $tree = $this->treeService->getTree();
        $userUnits = $this->userService->userUnits();
        $tree = $this->treeService->setPermissions($tree, $userUnits);

        return $tree;
    }

    public function activeUnits($id)
    {

        $user = User::with('units')->findOrFail($id);

        $tree = $this->treeService->getTree();

        $tree = $this->treeService->setPermissions($tree, $this->userService->userUnits());

        $tree = $this->treeService->setActives($user->units->pluck('id')->all(), $tree);

        return $tree;
    }
}
