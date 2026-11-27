<?php

namespace App\Services;

use App\Models\Descriptions\VolunteerStatus;
use App\Models\File;
use App\Models\Unit;
use App\Models\User;
use App\Models\Volunteer;

class VolunteerService
{
    private FileService $fileService;

    private UnitService $unitService;

    private UserService $userService;

    public function __construct(FileService $fileService, UnitService $unitService, UserService $userService)
    {
        $this->fileService = $fileService;
        $this->unitService = $unitService;
        $this->userService = $userService;
    }

    /**
     * Get the volunteer ids of the currently logged in user.
     * A user can view all the volunteers but may only edit the volunteers
     * that are directly beneath his/her unit.
     * If the user is assigned to the root unit, return all volunteers.
     *
     * @return array
     */
    public function permittedVolunteers()
    {
        $permittedVolunteers = [];

        // check if the logged in user is assigned to root unit.
        // then return all the users since the admin is able to edit all of them.
        $root = $this->unitService->getRoot();

        $user = User::unit($root->id)->where('id', \Auth::id())->get();

        // user is admin/assigned to root
        if (count($user) > 0) {
            $volunteers = Volunteer::all();
            foreach ($volunteers as $volunteer) {
                array_push($permittedVolunteers, $volunteer);
            }
        } else {
            // get the user's units with their immediate children (first level)
            // and their volunteers
            $user = User::where('id', \Auth::id())->with('units.children.volunteers')->first();

            // loop through each unit and its children and add the user ids to the array
            // very klassy. will this be refactored? only the future will show...
            foreach ($user->units as $unit) {
                if (count($unit->children) > 0) {
                    foreach ($unit->children as $child) {
                        if (count($child->volunteers) > 0) {
                            foreach ($child->volunteers as $volunteer) {
                                if (! in_array($volunteer, $permittedVolunteers)) {
                                    array_push($permittedVolunteers, $volunteer);
                                }
                            }
                        }
                    }
                }
                if (count($unit->volunteers) > 0) {
                    foreach ($unit->volunteers as $volunteer) {
                        if (! in_array($volunteer, $permittedVolunteers)) {
                            array_push($permittedVolunteers, $volunteer);
                        }
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
    public function permittedVolunteersIds()
    {
        $volunteers = $this->permittedVolunteers();
        $permittedVolunteersIds = [];

        foreach ($volunteers as $i => $volunteer) {
            $permittedVolunteersIds[$i] = intval($volunteer->id);
        }

        return $permittedVolunteersIds;
    }

    /**
     * Check if the volunteer is permitted to be edited by the
     * currently logged in user
     *
     * @return bool
     */
    public function isPermitted($volunteerId)
    {
        $permittedVolunteers = $this->userService->permittedVolunteersIds();
        if (in_array($volunteerId, $permittedVolunteers)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Set the volunteer status of each unit.
     * We keep the volunteer status to the pivot table
     * 'volunteer_unit_status' to easily retrieve it.
     * We set it to the json object array to easily display
     * at the front end.
     *
     * @return mixed
     */
    public function setStatusToUnits($volunteer)
    {
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
     * @return mixed
     */
    public function getAvailableUnitVolunteers($unitId)
    {

        $volunteers = Volunteer::whereHas('units', function ($query) use ($unitId) {
            $query->where('unit_id', $unitId);
        })->orderBy('name', 'asc')->get();

        $unitVolunteers = [];
        foreach ($volunteers as $volunteer) {
            array_push($unitVolunteers, [
                'id' => $volunteer->id,
                'text' => $volunteer->fullName,
            ]);
        }

        return $unitVolunteers;
    }

    /**
     * After adding the datatables plugin,
     * we need to prepare the data before sending it to the client
     *
     * @return mixed
     */
    public function prepareForDataTable($volunteers)
    {
        $permittedVolunteers = $this->permittedVolunteersIds();

        $data = [];

        // check if user is root
        $root = false;
        if ($this->userService->isAdmin()) {
            $root = true;
        }

        // get the status of each unit to display to the list
        // and also check if the current user is permitted to edit the volunteer
        foreach ($volunteers as $volunteer) {

            $volunteer = $this->setStatusToUnits($volunteer);

            if (in_array($volunteer->id, $permittedVolunteers)) {
                $volunteer->permitted = true;
            } else {
                $volunteer->permitted = -false;
            }

            if ($root && count($volunteer->units) == 0) {
                $volunteer->assignToRoot = true;
            } else {
                $volunteer->assignToRoot = false;
            }

            array_push($data, $volunteer);
        }

        return $data;
    }

    /**
     * Store the files uploaded for the volunteer
     *
     * @return bool
     */
    public function storeFiles($files, $id)
    {
        foreach ($files as $file) {
            if ($file != null) {
                $destinationPath = public_path().'/assets/uploads/volunteers';
                $fileName = $file->getClientOriginalName();

                // check if file already exists
                if (file_exists($destinationPath.'/'.$fileName)) {
                    return false;
                } else {

                    $filename = $this->fileService->storeFile($file, $fileName, $destinationPath);

                    // create a row to the db to associate the file with the volunteer
                    $dbFile = new File([
                        'filename' => $filename,
                        'volunteer_id' => $id,
                    ]);
                    $dbFile->save();
                }
            }
        }

        return true;
    }
}
