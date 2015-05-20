<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class PagesController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        $lessons = ['first', 'second', 'third'];
        $name = 'Chris';
		return view('pages.home', compact('lessons', 'name'));
	}

    public function about()
    {
        return "Learn about me";
    }
}
