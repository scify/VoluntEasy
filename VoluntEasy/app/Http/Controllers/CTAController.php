<?php namespace App\Http\Controllers;


use App\Models\Action;

class CTAController extends Controller{


    public function __construct() {
        $this->middleware('auth', ['except' => ['cta']]);
    }


    public function cta(){

        $action = Action::find(1);

        return view('main.cta.cta', compact('action'));
    }

    public function participate($id){

        $action = Action::with('tasks.subtasks.workDates.volunteers')->find($id);

        return view('main.cta.participate', compact('action'));
    }

}
