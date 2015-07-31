<?php namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Unit;
use App\Services\Facades\UnitService;

class UnitApiController extends Controller{

    public function all(){
        $units = Unit::orderBy('description', 'ASC')->with('parent')->get();

        $data = UnitService::prepareForDataTable($units);

        return [ "data" => $data ];
    }

}
