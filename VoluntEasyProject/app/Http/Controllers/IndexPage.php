<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class IndexPage extends Controller {

    public function mainIndex() {
        return view('main.mainPage');
    }

}
