<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Services\Facades\UnitService;
use App\Services\Facades\UserService;
use App\Services\Facades\VolunteerService;

/**
 * Class TestController
 * @package App\Http\Controllers
 *
 * This controller is used to do some tests,
 * ie. print some data, check some routes etc.
 */
class TestController extends Controller
{

    public function test()
    {
      /*  $tree = UnitService::getTree()->lists('id');

        return $tree;
*/

        //return UserService::permittedUsersIds();

      //  return VolunteerService::permittedVolunteersIds();

        return VolunteerService::unassigned();
    }


    public function newVolunteers()
    {
        $volunteers = VolunteerService::getNew();

        return view("main.volunteers.list", compact('volunteers'));
    }
}
