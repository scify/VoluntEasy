<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\UserService;

class UserApiController extends Controller
{
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function all()
    {
        $users = User::with('units', 'actions', 'roles')->orderBy('name', 'asc')->get();

        $data = $this->userService->prepareForDataTable($users);

        return ['data' => $data];
    }
}
