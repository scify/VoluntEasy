<?php namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Action;
use App\Models\Collaboration;
use App\Models\Volunteer;
class CollaborationApiController extends Controller {


    public function all() {
        $collaborations =  Collaboration::with('type')->get();

        $data = $collaborations;

        return ["data" => $data];
    }
}
