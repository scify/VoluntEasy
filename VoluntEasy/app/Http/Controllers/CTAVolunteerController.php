<?php namespace App\Http\Controllers;

use App\Models\Action;
use App\Models\CTA\CTAVolunteer;
use App\Models\Descriptions\VolunteerStatus;
use App\Models\Volunteer;
use App\Services\Facades\VolunteerService;

/**
 * Responsible for the functions of the CTAVolunteer obj
 *
 * Class CTAVolunteerController
 * @package App\Http\Controllers
 */
class CTAVolunteerController extends Controller {


    public function __construct() {
        $this->middleware('auth');
    }


    /**
     * Update a ctaVolunteer
     *
     * @return mixed
     */
    public function update() {
        $ctaVolunteer = CTAVolunteer::find(\Request::get('ctaVolunteerId'));

        $isVolunteer = $ctaVolunteer->isVolunteer;
        if ($ctaVolunteer->email != \Request::get('email')) {
            $volunteer = Volunteer::where('email', \Request::get('email'))->first('id');
            if ($volunteer == null)
                $isVolunteer = 0;
            else
                $isVolunteer = 1;
        }

        $ctaVolunteer->update([
            'first_name' => \Request::get('first_name'),
            'last_name' => \Request::get('last_name'),
            'email' => \Request::get('email'),
            'phone_number' => \Request::get('phone_number'),
            'comments' => \Request::get('comments'),
            'isVolunteer' => $isVolunteer,
        ]);


        return $ctaVolunteer;
    }


    /**
     * Destroy a ctaVolunteer
     * @param $id
     */
    public function destroy($id) {

        $ctaVolunteer = CTAVolunteer::find($id);
        $ctaVolunteer->volunteer()->delete();
        $ctaVolunteer->dates()->delete();
        $ctaVolunteer->delete();
        return;
    }

    /**
     * Assign a CTAVolunteer to an existing volunteer profile
     *
     * @return mixed
     */
    public function assignToVolunteer() {

        $ctaVolunteer = CTAVolunteer::find(\Request::get('cta_volunteer_id'));
        $ctaVolunteer->volunteer()->attach(\Request::get('volunteer_id'));

        $action = Action::find(\Request::get('action_id'));

        //assign volunteer to action
        VolunteerService::addToAction($ctaVolunteer->volunteer, $action);

        return $ctaVolunteer;
    }
}
