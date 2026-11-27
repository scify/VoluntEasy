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
     * Update the step status to the given status (Complete, Incomplete)
     *
     * @return mixed
     */
    public function updateStepStatus($stepStatusId, $status, $comments, $assignTo) {
        //the id of the status, either Complete or Incomplete
        $statusId = StepStatus::where('description', $status)->first()->id;

        $stepStatus = VolunteerStepStatus::find($stepStatusId);
        $stepStatus->comments = $comments;
        $stepStatus->assignedTo = $assignTo;
        $stepStatus->step_status_id = $statusId;
        $stepStatus->save();

        return $stepStatus;
    }

    /**
     * Create a unit status
     *
     * @param $volunteerId
     * @param $unitId
     * @param $statusId
     */
    public function addUnitStatus($volunteerId, $unitId, $statusId) {

        $volunteerUnitStatus = new VolunteerUnitStatus([
            'volunteer_id' => $volunteerId,
            'unit_id' => $unitId,
            'volunteer_status_id' => $statusId
        ]);

        $volunteerUnitStatus->save();

        return;
    }

    /**
     * Change the volunteer's unit status.
     * For example change to active if volunteer
     * is assigned to an action
     * or change back to available if volunteer is removed from action.
     *
     * @param $volunteerId
     * @param $unitId
     * @param $statusId
     */
    public function changeUnitStatus($volunteerId, $unitId, $statusId) {

        $volunteerUnitStatus = VolunteerUnitStatus::where('volunteer_id', $volunteerId)
            ->where('unit_id', $unitId)->first();

        if ($volunteerUnitStatus == null)
            $this->addUnitStatus($volunteerId, $unitId, $statusId);
        else {
            $volunteerUnitStatus->delete();
            $this->addUnitStatus($volunteerId, $unitId, $statusId);
        }

        return;
    }

    /**
     * Delete a volunteer unit status (soft delete)
     *
     * @param $volunteerId
     * @param $unitId
     */

    public function deleteUnitStatus($volunteerId, $unitId) {

        $volunteerUnitStatus = VolunteerUnitStatus::where('volunteer_id', $volunteerId)
            ->where('unit_id', $unitId)->whereNull('deleted_at')->first();

        $volunteerUnitStatus->delete();

        return;
    }

    /**
     * After the volunteer has the status of 'not available',
     * s/he will be available to units/actions again.
     *
     * @param $durationId
     * @return mixed
     */
    public function setVolunteerToAvailable($durationId) {
        $volunteer_status_duration = VolunteerStatusDuration::find($durationId);

        $volunteer_status_duration->delete();

        $volunteer = Volunteer::findOrFail($volunteer_status_duration->volunteer_id);

        $volunteer->not_available = false;
        $volunteer->update();

        return $volunteer_status_duration->volunteer_id;
    }

    /**
     * Add a volunteer to the root unit
     * and also create the steps that are needed (status set to incomplete)
     *
     * @param $id
     * @return bool
     */
    public function addToRootUnit($id) {

        if (UserServiceFacade::isAdmin()) {

            $rootUnit = UnitServiceFacade::getRoot();
            $rootUnit->load('steps');

            $volunteer = Volunteer::where('id', $id)->with('steps.status')->first();

            //check if the steps already exist
            if (sizeof(array_diff($rootUnit->steps->pluck('id')->all(), $volunteer->steps->pluck('step_id')->all()))) {

                $incompleteStatus = StepStatus::where('description', 'Incomplete')->first();

                //for each step of the unit, create a step, set its status to incomplete
                //and assign to volunteer
                $steps = [];
                foreach ($rootUnit->steps as $step) {
                    array_push($steps, new VolunteerStepStatus([
                        'step_id' => $step->id,
                        'step_status_id' => $incompleteStatus->id
                    ]));
                }
                $volunteer->steps()->saveMany($steps);
            }

            //$rootUnit->volunteers()->attach($volunteer, ['volunteer_status_id' => VolunteerStatus::pending()]);
            $this->changeUnitStatus($volunteer->id, $rootUnit->id, VolunteerStatus::pending());

            $this->unitHistory($volunteer->id, $rootUnit->id);

            return true;
        } else {
            return false;
        }
    }

    /**
     * Add a volunteer to a unit
     * and also create the steps that are needed (status set to incomplete).
     * Also send notifications to the users that are assigned to that unit.
     *
     * @param $unitId
     * @param $parentUnitId
     * @param $volunteerId
     * @return mixed
     */
    public function addToUnit($unitId, $parentUnitId, $volunteerId) {

        //check if the user assigned the volunteer to his/her unit
        //or to a child unit
        if ($parentUnitId != null && $unitId == $parentUnitId) {

            //if the volunteer is assigned to current unit, just change the status to available
            $volunteerStatus = VolunteerStatus::where('description', 'Available')->first()->id;

            $this->changeUnitStatus($volunteerId, $unitId, $volunteerStatus);

        } else {

            //get the pending volunteer status
            $volunteerStatus = VolunteerStatus::where('description', 'Pending')->first()->id;

            //get the unit's steps and the volunteer steps
            $unit = Unit::with('steps')->findOrFail($unitId);
            $volunteer = Volunteer::with('steps.status')->findOrFail($volunteerId);

            //check if the steps already exist
            //if they don't exist, then create the steps,
            //and set their status to pending
            if (sizeof(array_diff($unit->steps->pluck('id')->all(), $volunteer->steps->pluck('step_id')->all())) != 0) {

                $incompleteStatus = StepStatus::where('description', 'Incomplete')->first();

                //for each step of the unit, create a step, set its status to incomplete
                //and assign to volunteer
                $steps = [];
                foreach ($unit->steps as $step) {
                    array_push($steps, new VolunteerStepStatus([
                        'step_id' => $step->id,
                        'step_status_id' => $incompleteStatus->id
                    ]));
                }
                //append the steps to the volunteer
                $volunteer->steps()->saveMany($steps);

            } else {

                //if the steps already exists, that means that the volunteer has already passed the steps
                //and can be assigned directly to the unit without creating steps

                $volunteerId = $volunteer->id;
                $pending = StepStatus::incomplete();

                $steps = $unit->steps->pluck('id')->all();

                $volunteer = Volunteer::with(['steps' => function ($query) use ($steps, $pending) {
                    $query->whereIn('step_id', $steps)->whereHas('status', function ($q) use ($pending) {
                        $q->where('step_status_id', $pending);
                    });
                }])->findOrFail($volunteerId);

                //if the volunteer has pending steps on that unit, then the status is pending (fetched before)
                //else the status is available
                if (sizeof($volunteer->steps) == 0)
                    $volunteerStatus = VolunteerStatus::where('description', 'Available')->first()->id;
            }

            //if the user is assigned to a child unit, then detach it from its parent
            if (\Request::filled('parent_unit_id') && \Request::get('parent_unit_id') != '') {
                $parentUnit = Unit::find(\Request::get('parent_unit_id'));
                //$parentUnit->volunteers()->detach($volunteer->id);
                $this->deleteUnitStatus($volunteer->id, \Request::get('parent_unit_id'));
            }

            //attach the volunteer to the unit with the appropriate status
            //status can be either pending, if the volunteer has never completed the steps for that unit before
            //or available, if the volunteer has completed the steps
            //$unit->volunteers()->attach($volunteer, ['volunteer_status_id' => $volunteerStatus]);
            $this->changeUnitStatus($volunteer->id, $unit->id, $volunteerStatus);

            //also add an entry to the history table
            $this->unitHistory($volunteer->id, $unit->id);

            //notify users about new volunteers
            //only if the unit is not root unit
            //(no need to notify the admin about his/her action.
            if (!UnitServiceFacade::isRoot($unit))
                NotificationServiceFacade::newVolunteer($volunteerId, $unitId);

        }

        return $volunteerId;
    }

    /**
     * Add a volunteer to an action
     *
     * @param $volunteer
     * @param $action
     */
    public function addToAction($volunteer, $action) {
        $statusId = VolunteerStatus::active();

        //change unit status to active
        $this->changeUnitStatus($volunteer->id, $action->unit_id, $statusId);

        //attach volunteer to action
        $action->volunteers()->attach($volunteer);

        //add history entry
        $this->actionHistory($volunteer->id, $action->id);

        return;
    }

    /**
     * Remove a volunteer from an action
     *
     * @param $volunteer
     * @param $action
     */
    public
    function removeFromAction($volunteer, $action) {
        $statusId = VolunteerStatus::available();

        //change unit status to active
        $this->changeUnitStatus($volunteer->id, $action->unit_id, $statusId);

        //detach from action
        $volunteer->actions()->detach($action->id);

        return;
    }

    /**
     * When assigning a volunteer to a unit,
     * also save an entry to the history table
     *
     * @param $volunteerId
     * @param $unitId
     */
    public
    function unitHistory($volunteerId, $unitId) {

        $unitHistory = new VolunteerUnitHistory([
            'volunteer_id' => $volunteerId,
            'unit_id' => $unitId,
            'user_id' => \Auth::id(),
            'created' => \Carbon::now()
        ]);

        $unitHistory->save();
    }

    /**
     * When assigning a volunteer to an action,
     * also save an entry to the history table
     *
     * @param $volunteerId
     * @param $actionId
     */
    public
    function actionHistory($volunteerId, $actionId) {

        $actionHistory = new VolunteerActionHistory([
            'volunteer_id' => $volunteerId,
            'action_id' => $actionId,
            'user_id' => \Auth::id(),
            'created' => date('Y-m-d H:i:s')
        ]);

        $actionHistory->save();
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
