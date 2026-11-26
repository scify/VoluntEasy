<?php namespace App\Http\Controllers;

class EtcController extends Controller {


    /**
     * Create a new controller instance.
     *
     */
    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Show the FAQ page
     */
    public function faq() {
        return view('etc.faq');
    }
}
