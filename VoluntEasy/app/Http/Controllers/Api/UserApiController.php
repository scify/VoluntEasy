<?php namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Volunteer;
use App\Services\Facades\UserService;
use App\Services\Facades\VolunteerService;

class UserApiController extends Controller{

    public function all(){
        $users = User::with('units', 'actions', 'roles')->orderBy('name', 'ASC')->get();

        $data = UserService::prepareForDataTable($users);

        return [  "data" => $data ];
    }


}
