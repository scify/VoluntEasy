<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Models\Action;
use App\Models\Unit;
use App\Models\Volunteer;
use App\Services\Facades\UnitService;
use App\Services\Facades\UserService;
use App\Services\Facades\VolunteerService;
use Faker\Factory;
use Symfony\Component\Yaml\Tests\A;

/**
 * Class TestController
 * @package App\Http\Controllers
 *
 * This controller is used to do some tests,
 * ie. print some data, check some routes etc.
 */
class TestController extends Controller {

    public function test() {
        /*  $tree = UnitService::getTree()->lists('id');

          return $tree;
  */

        //return UserService::permittedUsersIds();

        //  return VolunteerService::permittedVolunteersIds();

        //  return VolunteerService::volunteersByStatus(2);



        return VolunteerService::timeline(12);

      /*  $vol = Volunteer::available();

        return UserService::permittedVolunteersIds();

        return $vol;

        return '';*/
    }


    public function newVolunteers() {
        $volunteers = VolunteerService::getNew();

        return view("main.volunteers.list", compact('volunteers'));
    }


    /**
     * generate some dummy data
     */
    public function faker() {
        $faker = Factory::create();


        for ($i = 0; $i < 10; $i++) {

            $volunteer = new Volunteer([
                'name' => $faker->firstName,
                'last_name' => $faker->lastName,
                'fathers_name' => $faker->firstNameMale,
                'birth_date' => $faker->dateTimeBetween('-70 years', '-15 years'),
                'address' =>$faker->address,
                'city' => $faker->city,
                'country' => 'Ελλάδα',
                'participation_reason' => $faker->paragraph,
                'participation_previous' => $faker->paragraph,
                'participation_actions' => $faker->paragraph,
                'home_tel' => $faker->phoneNumber,
                'work_tel' => $faker->phoneNumber,
                'cell_tel' => $faker->phoneNumber,
                'email' => $faker->safeEmail,
                'gender_id' => $faker->numberBetween(1, 2),
                'driver_license_type_id' => $faker->numberBetween(1, 6),
                'education_level_id' => $faker->numberBetween(1, 5),
                'identification_type_id' => $faker->numberBetween(1, 3),
                'marital_status_id' => $faker->numberBetween(1, 4),
                'work_status_id' => $faker->numberBetween(1, 4),
                'availability_freqs_id' => $faker->numberBetween(1, 3),

                ]);

            $volunteer->save();
        }

        for ($i = 1; $i < 11; $i++) {
            $unitIds = Unit::all()->lists('id');
            $unit = new Unit([
                'description' => $faker->colorName,
                'parent_unit_id' => $faker->randomElement($unitIds)
            ]);
            $unit->save();

            $unit->steps()->saveMany(UnitService::createSteps());
        }

        $leaves = Unit::whereDoesntHave('children')->lists('id');

        for ($i = 0; $i < 5; $i++) {
            $action = new Action([
                'description' => $faker->tld,
                'start_date' => $faker->dateTime(),
                'end_date' => $faker->dateTime(),
                'unit_id' => $faker->randomElement($leaves)
            ]);
            $action->save();
        }

        return 'Dummy data generated...';

    }
}
