<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class MenuController extends Controller {

    public function a1() {
        return view('main.units.unitEntry');
    }

    public function a2() {
        return view('main.units.listview');
    }

    public function a3() {
        return view('main.units.modifications');
    }

    public function a4() {
        return view('main.units.overview');
    }
//-----------------------------------------------------------------------//
    public function b1() {
        return view('main.actionsPrograms.actionListing');
    }

    public function b2() {
        return view('main.actionsPrograms.listview');
    }

    public function b3() {
        return view('main.actionsPrograms.modifications');
    }

    public function b4() {
        return view('main.actionsPrograms.overview');
    }

//-----------------------------------------------------------------------//
    public function c1() {
        return view('main.volunteers.listview');
    }

    public function c2() {
        return view('main.volunteers.statistics');
    }

//-----------------------------------------------------------------------//

    public function d1() {
        return view('main.users.userListing');
    }

    public function d2() {
        return view('main.users.listview');
    }

    public function d3() {
        return view('main.users.modifications');
    }

    public function d4() {
        return view('main.users.overview');
    }

//-----------------------------------------------------------------------//

    public function e1() {
        return view('main.sitemap.sitemap');
    }
}
