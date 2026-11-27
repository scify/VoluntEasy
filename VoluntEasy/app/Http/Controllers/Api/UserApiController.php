<?php namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Volunteer;
class UserApiController extends Controller{

    private \App\Services\UserService $userService;

    public function __construct(\App\Services\UserService $userService) {
        $this->userService = $userService;
    }

    public function all(){
        $users = User::with('units', 'actions', 'roles')->orderBy('name', 'asc')->get();

        $data = $this->userService->prepareForDataTable($users);

        return [  "data" => $data ];
    }

}
