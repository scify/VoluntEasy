<?php namespace App\Http\Controllers;

class TaskController extends Controller {


    /**
     * Create a new controller instance.
     *
     */
    public function __construct() {
        $this->middleware('auth');
    }


    public function store() {
        return view('etc.faq');
    }
}
