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
use App\Services\Facades\SearchService as Search;
use App\Services\Facades\UnitService as UnitServiceFacade;
use App\Services\Facades\UserService as UserServiceFacade;

class VolunteerService {

    /**
     * This array holds the names of the filters that the user is able to search by.
     * Filters correspond to column names.
     * @var array
     */
    //private $filters = [ 'name', 'last_name', 'email', 'marital_status_id' ];
    private $filters = [
        'name' => 'like%',
        'last_name' => 'like%',

        'email' => '=',
        'marital_status_id' => '=',
        'gender_id' => '=',
        'work_status_id' => '=',
        'education_level_id' => '=',

        'city' => '=',
        'country' => '=',
        'additional_skills' => '=',
        'work_description' => '=',
        'specialty' => '=',
        'department' => '=',
        'phoneNumber' => '=',
        'participation_actions' => '=',
        'computer_usage' => '=',
        'computer_usage_comments' => '=',

        'extra_lang' => '%like%',

        'age-range' => '',
        'unit_id' => '',
        'my_volunteers' => '',
        'status_id' => '',
        'interest_id' => '',
        'rating_id' => '',
        'contract_date' => '',
        'languages' => '',
    ];


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

        $user = User::unit($root->id)->where('id', \Auth::user()->id)->get();

        //user is admin/assigned to root
        if (sizeof($user) > 0) {
            $volunteers = Volunteer::all();
            foreach ($volunteers as $volunteer)
                array_push($permittedVolunteers, $volunteer);
        } else {
            //get the user's units with their immediate children (first level)
            //and their volunteers
            $user = User::where('id', \Auth::user()->id)->with('units.children.volunteers')->first();

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

    public function permittedAvailableVolunteers() {
        //dd($this->permittedVolunteersIds());

        $volunteers = Volunteer::available($this->permittedVolunteersIds());
        return $volunteers;
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
     * Get volunteers based on a given status.
     *
     * Statuses may be:
     *
     * 1: upo entaksi/pending
     * 2: dia8esimoi/not in any action, have completed all steps for a certain unit
     * 3: energoi/active/currently in an action
     * 4: mh dia8esimoi/akatallhloi/blacklisted/a manually set status
     * 0: unassigned/new
     *
     * @param $statusId
     * @param null $unitId
     * @return mixed
     */
    public function volunteersByStatus($statusId, $unitId = null) {

        switch ($statusId) {
            case '1':
                return Volunteer::unassigned();
                break;
            case '2':
                return Volunteer::pending();
                break;
            case '3':
                return Volunteer::available();
                break;
            case '4':
                return Volunteer::active();
                break;
            case '5':
                return Volunteer::notAvailable();
                break;
            case '6':
                return Volunteer::blacklisted();
                break;
        }

    }

    /**
     * For a certain action, get only the volunteers that
     * can be assigned to the action.
     * Those are the volunteers assigned to the parent unit,
     * whose status is either available or active.
     *
     * @param $actionId
     * @return mixed
     */
    public function getAvailableVolunteers($actionId) {
        $unit = Unit::whereHas('allActions', function ($query) use ($actionId) {
            $query->where('id', $actionId);
        })->with(['volunteers' => function ($query) {
            $query->active();
        }, 'volunteers' => function ($query) {
            $query->available();
        }])->get();

        return $unit;
    }


    /**
     * Get the volunteer units and their actions,
     * only if the user is assigned to any of the units' actions.
     *
     * @param $id
     * @return mixed
     */
    public function fullProfile($id) {

        $volunteer = Volunteer::with('gender', 'identificationType', 'driverLicenceType',
            'educationLevel', 'languages.level', 'languages.language',
            'interests', 'workStatus', 'availabilityTimes', 'availabilityFrequencies',
            'availabilityDays', 'actions', 'unitsExcludes', 'files', 'howYouLearned',
            'howYouLearned2', 'ctaVolunteers.dates.date.subtask.task.action')
            ->with(['units.steps.statuses' => function ($query) use ($id) {
                $query->where('volunteer_id', $id)->with('status');
            }])
            ->with(['actionHistory.action.allTasks.allSubtasks.allWorkDates.volunteers' => function ($q) use ($id) {
                $q->where('volunteer_id', $id);
            }])
            ->with('units.children', 'units.actions', 'workDateHistory.workDate.subtask', 'extras', 'volunteeringDepartments')
            ->with('opaRatings.laborSkills.skill', 'opaRatings.interpersonalSkills.skill', 'opaRatings.action', 'opaRatings.actionRating')
            ->findOrFail($id);

        $volunteer->hideStatus = false;

        //if the volunteer is not available, load the duration
        if ($volunteer->not_available)
            $volunteer->load('statusDuration.status');

        foreach ($volunteer->statusDuration as $duration) {
            if ($duration->status->description == 'Not available') {
                $volunteer->not_availableFrom = $duration->from_date;
                $volunteer->not_availableTo = $duration->to_date;
                $volunteer->not_availableComments = $duration->comments;
                $volunteer->not_availableId = $duration->id;
            }

            //also, if the volunteer is not available
            //and the current date is between that period, we should not display the current status
            //or be able to assign the volunteer anywhere
            $now = \Carbon::now();

            $from = \Carbon::createFromFormat('d/m/Y', $volunteer->not_availableFrom);
            $to = \Carbon::createFromFormat('d/m/Y', $volunteer->not_availableTo);

            if ($now->between($from, $to))
                $volunteer->hideStatus = true;
        }

        //get volunteer's age
        if (\DateTime::createFromFormat('d/m/Y', $volunteer->birth_date)) {
            $birth_date = \Carbon::createFromFormat('d/m/Y', $volunteer->birth_date);
            $volunteer->age = \Carbon::createFromDate($birth_date->year, $birth_date->month, $birth_date->day)->age;
        } else
            $volunteer->age = -1;


        //get the language levels in a readable array
        $lang_levels = [];
        foreach ($volunteer->languages as $language) {
            $lang_levels[$language->language->description] = $language->level->id;
        }

        $volunteer->lang_levels = $lang_levels;


        $unitsExcludes = $volunteer->unitsExcludes->lists('id')->all();
        $assignedUnits = $volunteer->units->lists('id')->all();

        //this is basically a hack.
        //in the front end we want to display a list of the available units for each unit
        //that the volunteer can be assigned to, that is the unit's children
        //so we create an array holding all the units info.
        foreach ($volunteer->units as $unit) {
            if (!in_array($unit->id, $unitsExcludes)) {
                $children = [];

                foreach ($unit->children as $child) {
                    if (!in_array($child->id, $unitsExcludes) && !in_array($child->id, $assignedUnits))
                        $children[$child->id] = $child->description;
                }
                $unit->availableUnits = $children;
            }
        }

        //another hack, similar to the above.
        //we also want to display all available units that the volunteer can be assigned to.
        //these are the units that the current user has access to
        //minus the units that the volunteer is already assigned to
        //minus the units that the volunteer is excluded from
        $availableUnits = [];

        //if the volunteer has no units, then
        //the only available unit should be the root one.
        if (sizeof($volunteer->units) == 0) {
            $root = UnitServiceFacade::getRoot();
            $availableUnits[$root->id] = $root->description;
        } else {
            //the query
            $user = User::with(['units' => function ($q) use ($unitsExcludes, $assignedUnits) {
                $q->whereNotIn('id', $unitsExcludes)->whereNotIn('id', $assignedUnits)
                    ->with(['children' => function ($q) use ($unitsExcludes, $assignedUnits) {
                        $q->whereNotIn('id', $unitsExcludes)
                            ->whereNotIn('id', $assignedUnits);
                    }]);
            }])->findOrFail(\Auth::user()->id);

            //create an array of the above json
            $availableUnits = [];
            foreach ($user->units as $unit) {
                $availableUnits[$unit->id] = $unit->description;

                foreach ($unit->children as $child)
                    $availableUnits[$child->id] = $child->description;
            }
        }
        $volunteer->availableUnits = $availableUnits;

        //remove the subtasks that have no volunteers assigned
        //(the work dates will either have one volunteer, the current one, or no volunteers
        foreach ($volunteer->actionHistory as $h => $history) {
            foreach ($history->action->allTasks as $t => $task) {
                foreach ($task->allSubtasks as $s => $subtask) {
                    foreach ($volunteer->workDateHistory as $wdHistory) {

                        if ($wdHistory->workDate->trashedSubtask->id == $subtask->id) {
                            $to_time = strtotime($wdHistory->workDate->to_hour);
                            $from_time = strtotime($wdHistory->workDate->from_hour);
                            $workHours = (($to_time - $from_time) / 60) / 60;
                            $wdHistory->workDate->workHours = $workHours;
                            $subtask->workHours += $wdHistory->workDate->workHours;
                            break;
                        }
                    }
                    $task->workHours += $subtask->workHours;
                }
                $history->action->workHours += $task->workHours;
            }
        }

        //add the descriptions of the skills
        //that the volunteer thas not received a rating for to the array
        $laborSkills = LaborSkill::all();
        $interpersonalSkills = InterpersonalSkill::all();
        $laborSkillsTmp = $laborSkills;
        $interpersonalSkillsTmp = $interpersonalSkills;

        return $volunteer;
    }

    /**
     * For a volunteer, get the info from the history tables
     * and add them to an array to easily display the data at the front end
     *
     * @param $volunteerId
     * @return array[]
     */
    public
    function timeline($volunteerId) {

        $volunteer = Volunteer::with('actionHistory.user')
            ->with('unitHistory.user')
            ->with(['actionHistory.action' => function ($query) use ($volunteerId) {
                $query->withTrashed()->with(['ratings.volunteerRatings' => function ($query) use ($volunteerId) {
                    $query->where('volunteer_id', $volunteerId)->with('ratings.attribute');
                }]);
            }])
            ->with(['unitHistory.unit' => function ($query) use ($volunteerId) {
                $query->withTrashed()->with(['steps' => function ($query) use ($volunteerId) {
                    $query->withTrashed()->with(['statuses' => function ($query) use ($volunteerId) {
                        $query->where('volunteer_id', $volunteerId)->with('status');
                    }]);
                }]);
            }])
            ->with(['statusDuration' => function ($query) {
                $query->withTrashed()->orderBy('from_date')->with('status');
            }])
            ->findOrFail($volunteerId);

        $timeline = [];

        //get info from the history tables
        foreach ($volunteer->actionHistory as $actionHistory) {
            $actionHistory->type = 'action';
            array_push($timeline, $actionHistory);
        }


        //unit history table
        foreach ($volunteer->unitHistory as $unitHistory) {
            $unitHistory->type = 'unit';
            array_push($timeline, $unitHistory);
        }

        //status duration
        foreach ($volunteer->statusDuration as $statusHistory) {
            $statusHistory->type = 'status';
            $statusHistory->created_at = \Carbon::createFromFormat('d/m/Y', $statusHistory->to_date)->format('Y-m-d');
            array_push($timeline, $statusHistory);
        }

        //sort the array by date
        usort($timeline, function ($a, $b) {
            return $a->created_at > $b->created_at ? -1 : 1;
        });

        return $timeline;
    }


    /**
     * For a volunteer, we should be able to calculate
     * the total hours s/he was in all the actions s/he participated in.
     *
     * @param $timeline
     * @return mixed
     */
    public
    function totalWorkingHours($timeline) {
        $totalHours = 0;
        $totalMinutes = 0;

        //for each timeline block, loop and check it's type
        //if it's an action that has been rated, we can keep
        //the hours and minutes
        foreach ($timeline as $block) {
            if ($block->type == "action"
                && isset($block->action->ratings) && sizeof($block->action->ratings) > 0
                && isset($block->action->ratings[0]->volunteerRatings[0]) && sizeof($block->action->ratings[0]->volunteerRatings[0]) > 0
            ) {
                $totalHours += $block->action->ratings[0]->volunteerRatings[0]->hours;
                $totalMinutes += $block->action->ratings[0]->volunteerRatings[0]->minutes;
            }
        }

        if ($totalHours != 0 && $totalMinutes != 0) {
            if ($totalMinutes > 59) {
                $totalHours += intval($totalMinutes / 60);
                $totalMinutes = $totalMinutes % 60;
            }
        }

        return ['hours' => $totalHours, 'minutes' => $totalMinutes];
    }

    /**
     * Get all the ratings for a volunteer's actions
     *
     * @param $volunteerId
     * @return mixed
     */
    public
    function actionsRatings($volunteerId) {

        $volunteer = Volunteer::find($volunteerId)->whereHas('actions.ratings.volunteerRatings', function ($q) use ($volunteerId) {
            $q->where('volunteer_id', $volunteerId);
        })->get();

        $volunteer = Volunteer::with('actionHistory')->find($volunteerId);

        $actions = Action::whereIn('id', $volunteer->actionHistory->lists('action_id')->all())
            ->with(['ratings.volunteerRatings' => function ($q) use ($volunteerId) {
                $q->where('volunteer_id', $volunteerId)->with('ratings.attribute');
            }])->get();


        foreach ($actions as $action) {
            if (isset($action->ratings)) {
                $ratings = [];
                $action->ratingCount = 0;
                foreach ($action->ratings as $rating) {
                    $action->ratingHours = 0;
                    $action->ratingMinutes = 0;
                    if (isset($rating->volunteerRatings)) {
                        foreach ($rating->volunteerRatings as $volRating) {

                            $action->ratingHours += $volRating->hours;
                            $action->ratingMinutes += $volRating->minutes;
                            $action->ratingComments = $volRating->comments;
                            $action->ratingCount++;

                            if (isset($volRating->ratings)) {
                                foreach ($volRating->ratings as $r) {
                                    if (!isset($ratings[$r->attribute->description]))
                                        $ratings[$r->attribute->description]['rating'] = $r->rating;
                                    else
                                        $ratings[$r->attribute->description]['rating'] += $r->rating;
                                }
                            }
                        }
                    }
                }
                unset($action->ratings);
                $action->ratings = $ratings;
            }
        }

        return $actions;
    }


    /**
     * Update the step status to the given status (Complete, Incomplete)
     *
     * @return mixed
     */
    public
    function updateStepStatus($stepStatusId, $status, $comments, $assignTo) {
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
    public
    function addUnitStatus($volunteerId, $unitId, $statusId) {

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
    public
    function changeUnitStatus($volunteerId, $unitId, $statusId) {

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

<<<<<<< HEAD
    public function deleteUnitStatus($volunteerId, $unitId) {
=======
    public
    function deleteUnitStatus($volunteerId, $unitId) {
>>>>>>> dbce65803bb4e2d9d8f82790ba4d937e797d2775
        $volunteerUnitStatus = VolunteerUnitStatus::where('volunteer_id', $volunteerId)
            ->where('unit_id', $unitId)->whereNull('deleted_at')->first();

        $volunteerUnitStatus->delete();

        return;
    }
<<<<<<< HEAD

=======
>>>>>>> dbce65803bb4e2d9d8f82790ba4d937e797d2775

    /**
     * After the volunteer has the status of 'not available',
     * s/he will be available to units/actions again.
     *
     * @param $durationId
     * @return mixed
     */
    public
    function setVolunteerToAvailable($durationId) {
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
    public
    function addToRootUnit($id) {

        if (UserServiceFacade::isAdmin()) {

            $rootUnit = UnitServiceFacade::getRoot();
            $rootUnit->load('steps');

            $volunteer = Volunteer::where('id', $id)->with('steps.status')->first();

            //check if the steps already exist
            if (sizeof(array_diff($rootUnit->steps->lists('id')->all(), $volunteer->steps->lists('step_id')->all()))) {

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
    public
    function addToUnit($unitId, $parentUnitId = null, $volunteerId) {

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
            if (sizeof(array_diff($unit->steps->lists('id')->all(), $volunteer->steps->lists('step_id')->all())) != 0) {

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

                $steps = $unit->steps->lists('id')->all();

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
            if (\Request::has('parent_unit_id') && \Request::get('parent_unit_id') != '') {
<<<<<<< HEAD
                $parentUnit = Unit::find(\Request::get('parent_unit_id'));
                //$parentUnit->volunteers()->detach($volunteer->id);
                 $this->deleteUnitStatus($volunteer->id, \Request::get('parent_unit_id'));
=======
                //$parentUnit = Unit::find(\Request::get('parent_unit_id'));
                //$parentUnit->volunteers()->detach($volunteer->id);
                $this->deleteUnitStatus($volunteer->id, \Request::get('parent_unit_id'));
>>>>>>> dbce65803bb4e2d9d8f82790ba4d937e797d2775
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
    public
    function addToAction($volunteer, $action) {
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
            'user_id' => \Auth::user()->id,
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
            'user_id' => \Auth::user()->id,
            'created' => date('Y-m-d H:i:s')
        ]);

        $actionHistory->save();
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
    public
    function storeFiles($files, $id) {
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
    }

    /**
     * Dynamic search chains a lot of queries depending on the filters sent by the user.
     *
     * @return mixed
     */
    public
    function search() {
        $ratingId = -1;

        if (\Input::has('my_volunteers')) {
            $permittedVolunteersIds = $this->permittedVolunteersIds();
            $query = Volunteer::whereIn('id', $permittedVolunteersIds);

        } else
            $query = Volunteer::select();


        if (\Input::has('status_id') && !Search::notDropDown(\Input::get('status_id'), 'status_id')) {
            $query = $this->volunteersByStatus(\Input::get('status_id'));
        }

        foreach ($this->filters as $column => $filter) {
            if (\Input::has($column) && \Input::get($column) != "") {
                $value = \Input::get($column);
                switch ($filter) {
                    case '=':
                        if (!Search::notDropDown($value, $column))
                            $query->where($column, '=', $value);
                        break;
                    case 'like%':
                        $query->where($column, 'like', $value . '%');
                        break;
                    case '%like%':
                        $query->where($column, 'like', '%' . $value . '%');
                        break;
                    case '':
                        switch ($column) {
                            case 'age-range':
                                $ages = explode("-", $value);

                                $date = date('Y-m-d');
                                $newdate = strtotime('-' . $ages[0] . ' year', strtotime($date));
                                $ages[0] = date('Y-m-j', $newdate);
                                $date = date('Y-m-d');
                                $newdate = strtotime('-' . $ages[1] . ' year', strtotime($date));
                                $ages[1] = date('Y-m-j', $newdate);

                                $query->whereBetween('birth_date', [$ages[1], $ages[0]]);
                                break;
                            case 'phoneNumber':
                                $query->where('home_tel', \Input::get('phoneNumber'))
                                    ->orWhere('work_tel', \Input::get('phoneNumber'))
                                    ->orWhere('cell_tel', \Input::get('phoneNumber'));
                                break;
                            case 'unit_id':
                                if (!Search::notDropDown($value, $column)) {
                                    $id = \Input::get('unit_id');
                                    $query->whereHas('units', function ($query) use ($id) {
                                        $query->where('unit_id', $id);
                                    });
                                }
                                break;
                            case 'interest_id':
                                if (!Search::notDropDown($value, $column)) {
                                    $id = \Input::get('interest_id');
                                    $query->whereHas('interests', function ($query) use ($id) {
                                        $query->where('interest_id', $id);
                                    });
                                }
                                break;
                            case 'rating_id':
                                if (!Search::notDropDown($value, $column)) {
                                    $ratingId = \Input::get('rating_id');
                                }
                                break;
                            case 'contract_date':
                                $query->whereNotNull('contract_date');
                                break;
                            case 'languages':
                                foreach ($value as $v) {
                                    $query->whereHas('languages', function ($query) use ($v) {
                                        $query->where('language_id', $v);
                                    });
                                }
                                break;
                        }
                    default:
                        break;
                }
            }
        }

        $result = $query->orderBy('name', 'ASC')->with('actions', 'units')->get();

        /*
                //get the total rating for each attribute
                foreach ($result as $volunteer) {
                    if ($volunteer->ratings != null) {
                        $volunteer->rating_attr1 = $volunteer->ratings->rating_attr1 / $volunteer->ratings->rating_attr1_count;
                        $volunteer->rating_attr2 = $volunteer->ratings->rating_attr2 / $volunteer->ratings->rating_attr2_count;
                        $volunteer->rating_attr3 = $volunteer->ratings->rating_attr3 / $volunteer->ratings->rating_attr3_count;
                    } else {
                        $volunteer->rating_attr1 = 0;
                        $volunteer->rating_attr2 = 0;
                        $volunteer->rating_attr3 = 0;
                    }
                }

        //sort by rating
        if ($ratingId != -1) {
            switch ($ratingId) {
                case '1':
                    $result = $result->sortBy('rating_attr1');
                    break;
                case '2':
                    $result = $result->sortByDesc('rating_attr1');
                    break;
                case '3':
                    $result = $result->sortBy('rating_attr2');
                    break;
                case '4':
                    $result = $result->sortByDesc('rating_attr2');
                    break;
                case '5':
                    $result = $result->sortBy('rating_attr3');
                    break;
                case '6':
                    $result = $result->sortByDesc('rating_attr3');
                    break;
            }
        }
*/
        $data = $this->prepareForDataTable($result);

        return ["data" => $data];
    }

}
