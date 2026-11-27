<?php namespace App\Services;

use App\Models\Action;
use App\Models\Descriptions\StepStatus;
use App\Models\Descriptions\VolunteerStatus;
use App\Models\Descriptions\VolunteerStatusDuration;
use App\Models\File;
use App\Models\OPARating\InterpersonalSkill;
use App\Models\OPARating\LaborSkill;
use App\Models\Unit;
use App\Models\User;
use App\Models\Volunteer;
use App\Models\VolunteerActionHistory;
use App\Models\VolunteerStepStatus;
use App\Models\VolunteerUnitHistory;
use App\Models\VolunteerUnitStatus;
use App\Services\Facades\FileService as FileServiceFacade;
use App\Services\Facades\NotificationService as NotificationServiceFacade;
use App\Services\Facades\UnitService as UnitServiceFacade;
use App\Services\Facades\UserService as UserServiceFacade;

class VolunteerService {


    /**
     * From a list of volunteers, get a list of ids.
     *
     * @param $volunteers
     * @return mixed
     */
    public function volunteerIds($volunteers) {
        $ids = [];

        foreach ($volunteers as $volunteer)
            array_push($ids, $volunteer->id);

        return $ids;
    }

    /**
     * Get the volunteer ids of the currently logged in user.
     * A user can view all the volunteers but may only edit the volunteers
     * that are directly beneath his/her unit.
     * If the user is assigned to the root unit, return all volunteers.
     *
     * @return array
     */
    public function permittedVolunteers() {
        $permittedVolunteers = [];

        //check if the logged in user is assigned to root unit.
        //then return all the users since the admin is able to edit all of them.
        $root = UnitServiceFacade::getRoot();

        $user = User::unit($root->id)->where('id', \Auth::id())->get();

        //user is admin/assigned to root
        if (sizeof($user) > 0) {
            $volunteers = Volunteer::all();
            foreach ($volunteers as $volunteer)
                array_push($permittedVolunteers, $volunteer);
        } else {
            //get the user's units with their immediate children (first level)
            //and their volunteers
            $user = User::where('id', \Auth::id())->with('units.children.volunteers')->first();

            //loop through each unit and its children and add the user ids to the array
            //very klassy. will this be refactored? only the future will show...
            foreach ($user->units as $unit) {
                if (sizeof($unit->children) > 0) {
                    foreach ($unit->children as $child) {
                        if (sizeof($child->volunteers) > 0) {
                            foreach ($child->volunteers as $volunteer) {
                                if (!in_array($volunteer, $permittedVolunteers))
                                    array_push($permittedVolunteers, $volunteer);
                            }
                        }
                    }
                }
                if (sizeof($unit->volunteers) > 0) {
                    foreach ($unit->volunteers as $volunteer) {
                        if (!in_array($volunteer, $permittedVolunteers))
                            array_push($permittedVolunteers, $volunteer);
                    }
                }
            }
        }
        return $permittedVolunteers;
    }

    /**
     * Get only the ids of the permitted users
     *
     * @return array
     */
    public function permittedVolunteersIds() {
        $volunteers = $this->permittedVolunteers();
        $permittedVolunteersIds = [];

        foreach ($volunteers as $i => $volunteer)
            $permittedVolunteersIds[$i] = intval($volunteer->id);

        return $permittedVolunteersIds;
    }


    /**
     * Check if the volunteer is permitted to be edited by the
     * currently logged in user
     * @return bool
     */
    public function isPermitted($volunteerId) {
        $permittedVolunteers = UserServiceFacade::permittedVolunteersIds();
        if (in_array($volunteerId, $permittedVolunteers))
            return true;
        else
            return false;
    }

    /**
     * Set the volunteer status of each unit.
     * We keep the volunteer status to the pivot table
     * 'volunteer_unit_status' to easily retrieve it.
     * We set it to the json object array to easily display
     * at the front end.
     *
     * @param $volunteer
     * @return mixed
     */
    public function setStatusToUnits($volunteer) {
        foreach ($volunteer->units as $unit) {
            $statusId = \DB::table('volunteer_unit_status')
                ->select('volunteer_status_id')
                ->where('volunteer_id', $volunteer->id)
                ->where('unit_id', $unit->id)
                ->whereNull('deleted_at')
                ->first()->volunteer_status_id;
            $status = VolunteerStatus::findOrFail($statusId)->description;
            $unit->status = $status;
        }

        return $volunteer;
    }


















    /**
     * Find the volunteers that are available for a certain unit
     * and return them in array form
     *
     * @param $unitId
     * @return mixed
     */
    public function getAvailableUnitVolunteers($unitId) {

        $volunteers = Volunteer::whereHas('units', function ($query) use ($unitId) {
            $query->where('unit_id', $unitId);
        })->orderBy('name', 'asc')->get();

        $unitVolunteers = [];
        foreach($volunteers as $volunteer){
            array_push($unitVolunteers, [
                'id' => $volunteer->id,
                'text' => $volunteer->fullName
            ]);
        }

        return $unitVolunteers;
    }

    /**
     * After adding the datatables plugin,
     * we need to prepare the data before sending it to the client
     *
     * @param $volunteers
     * @return mixed
     */
    public
    function prepareForDataTable($volunteers) {
        $permittedVolunteers = VolunteerService::permittedVolunteersIds();

        $data = [];

        //check if user is root
        $root = false;
        if (UserServiceFacade::isAdmin())
            $root = true;

        //get the status of each unit to display to the list
        //and also check if the current user is permitted to edit the volunteer
        foreach ($volunteers as $volunteer) {

            $volunteer = $this->setStatusToUnits($volunteer);

            if (in_array($volunteer->id, $permittedVolunteers))
                $volunteer->permitted = true;
            else
                $volunteer->permitted = -false;

            if ($root && sizeof($volunteer->units) == 0)
                $volunteer->assignToRoot = true;
            else $volunteer->assignToRoot = false;

            array_push($data, $volunteer);
        }

        return $data;
    }

    /**
     * Store the files uploaded for the volunteer
     *
     * @param $files
     * @param $id
     * @return boolean
     */
    public function storeFiles($files, $id) {
        foreach ($files as $file) {
            if ($file != null) {
                $destinationPath = public_path() . '/assets/uploads/volunteers';
                $fileName = $file->getClientOriginalName();

                //check if file already exists
                if (file_exists($destinationPath . '/' . $fileName)) {
                    return false;
                } else {

                    $filename = FileServiceFacade::storeFile($file, $fileName, $destinationPath);

                    //create a row to the db to associate the file with the volunteer
                    $dbFile = new File([
                        'filename' => $filename,
                        'volunteer_id' => $id
                    ]);
                    $dbFile->save();
                }
            }
        }
        return true;
    }


}
