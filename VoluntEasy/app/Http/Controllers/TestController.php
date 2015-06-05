<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

/**
 * Class TestController
 * @package App\Http\Controllers
 *
 * This controller is used to do some tests,
 * ie. print some data, check some routes etc.
 */
class TestController extends Controller {

    public function userTest()
    {
        return view('test/');
    }

}
