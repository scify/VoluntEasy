<?php

namespace App\Services\Volunteers;

use App\Models\Action;
use App\Models\Unit;
use App\Models\User;
use App\Models\Volunteer;
use App\Services\Facades\UnitService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

/**
 * Everything that the volunteer profile page shows: the volunteer with the
 * values the page needs, the history timeline, working hours and ratings.
 */
class VolunteerProfile
{
    /**
     * The volunteer with all relations and the computed values of the profile page.
     */
    public function fullProfile($id): Volunteer
    {
        $volunteer = $this->loadVolunteer((int) $id);

        $this->setNotAvailablePeriod($volunteer);
        $volunteer->age = $this->age($volunteer);
        $volunteer->lang_levels = $volunteer->languages
            ->mapWithKeys(fn ($language) => [$language->language->description => $language->level->id])
            ->all();
        $this->setUnitsToAssign($volunteer);
        $this->setWorkHours($volunteer);

        return $volunteer;
    }

    private function loadVolunteer(int $id): Volunteer
    {
        return Volunteer::with('gender', 'identificationType', 'driverLicenceType',
            'educationLevel', 'languages.level', 'languages.language',
            'interests', 'workStatus', 'availabilityTimes', 'availabilityFrequencies',
            'availabilityDays', 'actions', 'unitsExcludes', 'files', 'howYouLearned',
            'howYouLearned2', 'ctaVolunteers.subtaskDates.date.subtask.task.action', 'statusDuration.status')
            ->with(['units.steps.statuses' => fn ($query) => $query->where('volunteer_id', $id)->with('status')])
            ->with(['actionHistory.action.allTasks.allSubtasks.allShifts.volunteers' => fn ($query) => $query->where('volunteer_id', $id)])
            ->with('units.children', 'units.actions', 'subtaskShiftHistory.shift.subtask', 'extras', 'volunteeringDepartments')
            ->with('opaRatings.laborSkills.skill', 'opaRatings.interpersonalSkills.skill', 'opaRatings.action', 'opaRatings.actionRating')
            ->findOrFail($id);
    }

    /**
     * Copy the "Not available" period to the volunteer. During that period
     * the page hides the status and does not allow assignments.
     */
    private function setNotAvailablePeriod(Volunteer $volunteer): void
    {
        $volunteer->hideStatus = false;

        foreach ($volunteer->statusDuration as $duration) {
            if ($duration->status->description !== 'Not available') {
                continue;
            }

            $volunteer->not_availableFrom = $duration->from_date;
            $volunteer->not_availableTo = $duration->to_date;
            $volunteer->not_availableComments = $duration->comments;
            $volunteer->not_availableId = $duration->id;

            $from = Carbon::createFromFormat('d/m/Y', $duration->from_date);
            $to = Carbon::createFromFormat('d/m/Y', $duration->to_date);
            $volunteer->hideStatus = Carbon::now()->between($from, $to);
        }
    }

    /** The age in years, or -1 if the birth date is not known. */
    private function age(Volunteer $volunteer): int
    {
        $birthDate = $volunteer->birth_date ? Carbon::createFromFormat('d/m/Y', $volunteer->birth_date) : null;

        return $birthDate ? (int) $birthDate->startOfDay()->age : -1;
    }

    /**
     * The units that the volunteer can be assigned to:
     * - for each unit of the volunteer, its child units ($unit->availableUnits);
     * - in total ($volunteer->availableUnits): the units of the current user and
     *   their children, or only the root unit if the volunteer has no unit.
     * Units that the volunteer is already in or is excluded from are left out.
     */
    private function setUnitsToAssign(Volunteer $volunteer): void
    {
        $excluded = $volunteer->unitsExcludes->pluck('id')->all();
        $assigned = $volunteer->units->pluck('id')->all();
        $notPossible = array_merge($excluded, $assigned);

        foreach ($volunteer->units as $unit) {
            if (! in_array($unit->id, $excluded)) {
                $unit->availableUnits = $unit->children
                    ->reject(fn (Unit $child) => in_array($child->id, $notPossible))
                    ->pluck('description', 'id')->all();
            }
        }

        if ($volunteer->units->isEmpty()) {
            $root = UnitService::getRoot();
            $volunteer->availableUnits = [$root->id => $root->description];

            return;
        }

        $user = User::with(['units' => fn ($query) => $query->whereNotIn('id', $notPossible)
            ->with(['children' => fn ($query) => $query->whereNotIn('id', $notPossible)])])
            ->findOrFail(Auth::id());

        $availableUnits = [];
        foreach ($user->units as $unit) {
            $availableUnits[$unit->id] = $unit->description;
            foreach ($unit->children as $child) {
                $availableUnits[$child->id] = $child->description;
            }
        }
        $volunteer->availableUnits = $availableUnits;
    }

    /**
     * Add the hours that the volunteer worked to each subtask, task and action
     * of the action history (from the volunteer's shift history).
     */
    private function setWorkHours(Volunteer $volunteer): void
    {
        foreach ($volunteer->actionHistory as $history) {
            foreach ($history->action->allTasks as $task) {
                foreach ($task->allSubtasks as $subtask) {
                    foreach ($volunteer->subtaskShiftHistory as $shiftHistory) {
                        if ($shiftHistory->shift->trashedSubtask->id == $subtask->id) {
                            $shiftHistory->shift->workHours = $shiftHistory->shift->workingHours();
                            $subtask->workHours += $shiftHistory->shift->workHours;
                            break;
                        }
                    }
                }

                foreach ($volunteer->taskShiftHistory as $shiftHistory) {
                    if ($shiftHistory->shift->trashedTask->id == $task->id) {
                        $shiftHistory->shift->workHours = $shiftHistory->shift->workingHours();
                        $task->workHours += $shiftHistory->shift->workHours;
                        break;
                    }
                }

                $history->action->workHours += $task->workHours;
            }
        }
    }


    /**
     * For a volunteer, get the info from the history tables
     * and add them to an array to easily display the data at the front end
     *
     * @param $volunteerId
     * @return list<\App\Models\VolunteerActionHistory|\App\Models\VolunteerUnitHistory|\App\Models\Descriptions\VolunteerStatusDuration> The action, unit and status history, newest first
     */
    public function timeline($volunteerId) {

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
     * The hours and minutes of the rated actions of the timeline.
     *
     * @param  iterable<object>  $timeline
     * @return array{hours: int, minutes: int}
     */
    public function totalWorkingHours(iterable $timeline): array
    {
        $minutes = 0;
        foreach ($timeline as $block) {
            $rating = $block->type === 'action' ? $block->action?->ratings[0]?->volunteerRatings[0] ?? null : null;
            if ($rating !== null) {
                $minutes += 60 * (int) $rating->hours + (int) $rating->minutes;
            }
        }

        return ['hours' => intdiv($minutes, 60), 'minutes' => $minutes % 60];
    }

    /**
     * The actions of the volunteer with the ratings that the volunteer got:
     * the sum of the ratings per attribute ("ratings"), the hours and minutes,
     * the number of ratings and the last comment.
     *
     * @return \Illuminate\Database\Eloquent\Collection<int, Action>
     */
    public function actionsRatings($volunteerId) {
        $volunteer = Volunteer::with('actionHistory')->findOrFail($volunteerId);

        $actions = Action::whereIn('id', $volunteer->actionHistory->pluck('action_id')->all())
            ->with(['ratings.volunteerRatings' => fn ($query) => $query->where('volunteer_id', $volunteerId)->with('ratings.attribute')])
            ->get();

        foreach ($actions as $action) {
            $volunteerRatings = $action->ratings->flatMap(fn ($rating) => $rating->volunteerRatings);

            $action->ratingCount = $volunteerRatings->count();
            if ($action->ratings->isNotEmpty()) {
                $minutes = $volunteerRatings->sum(fn ($rating) => 60 * (int) $rating->hours + (int) $rating->minutes);
                $action->ratingHours = intdiv($minutes, 60);
                $action->ratingMinutes = $minutes % 60;
            }
            if ($volunteerRatings->isNotEmpty()) {
                $action->ratingComments = $volunteerRatings->last()->comments;
            }

            $sums = [];
            foreach ($volunteerRatings->flatMap(fn ($rating) => $rating->ratings) as $attributeRating) {
                $sums[$attributeRating->attribute->description]['rating'] =
                    ($sums[$attributeRating->attribute->description]['rating'] ?? 0) + $attributeRating->rating;
            }

            //replace the ratings relation with the sums by attribute
            $action->unsetRelation('ratings');
            $action->setAttribute('ratings', $sums);
        }

        return $actions;
    }
}
