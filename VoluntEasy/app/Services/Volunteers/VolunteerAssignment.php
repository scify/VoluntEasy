<?php

namespace App\Services\Volunteers;

use App\Models\Action;
use App\Models\Descriptions\StepStatus;
use App\Models\Descriptions\VolunteerStatus;
use App\Models\Descriptions\VolunteerStatusDuration;
use App\Models\Unit;
use App\Models\Volunteer;
use App\Models\VolunteerActionHistory;
use App\Models\VolunteerStepStatus;
use App\Models\VolunteerUnitHistory;
use App\Models\VolunteerUnitStatus;
use Illuminate\Support\Facades\Auth;

/**
 * Adding volunteers to units and actions, and the status of a volunteer in
 * each unit (pending, available, active, ...).
 *
 * A volunteer who joins a unit first completes the unit's steps (for example
 * an interview): until then the status is "pending", then "available".
 * In an action the status is "active".
 */
class VolunteerAssignment
{

    private \App\Services\NotificationService $notificationService;
    private \App\Services\UnitService $unitService;
    private \App\Services\UserService $userService;

    public function __construct(\App\Services\NotificationService $notificationService, \App\Services\UnitService $unitService, \App\Services\UserService $userService) {
        $this->notificationService = $notificationService;
        $this->unitService = $unitService;
        $this->userService = $userService;
    }
    /**
     * Update a step of a volunteer (Complete or Incomplete).
     */
    public function updateStepStatus($stepStatusId, $status, $comments, $assignTo): VolunteerStepStatus
    {
        $stepStatus = VolunteerStepStatus::findOrFail($stepStatusId);
        $stepStatus->comments = $comments;
        $stepStatus->assignedTo = $assignTo;
        $stepStatus->step_status_id = StepStatus::where('description', $status)->firstOrFail()->id;
        $stepStatus->save();

        return $stepStatus;
    }

    /**
     * Set the status of a volunteer in a unit. The previous status is soft
     * deleted, so that the status history stays.
     */
    public function changeUnitStatus($volunteerId, $unitId, $statusId): void
    {
        VolunteerUnitStatus::where('volunteer_id', $volunteerId)->where('unit_id', $unitId)->first()?->delete();

        (new VolunteerUnitStatus([
            'volunteer_id' => $volunteerId,
            'unit_id' => $unitId,
            'volunteer_status_id' => $statusId,
        ]))->save();
    }

    /**
     * End the "not available" period of a volunteer.
     *
     * @return int The volunteer id
     */
    public function setVolunteerToAvailable($durationId): int
    {
        $duration = VolunteerStatusDuration::findOrFail($durationId);
        $duration->delete();

        $volunteer = Volunteer::findOrFail($duration->volunteer_id);
        $volunteer->not_available = false;
        $volunteer->update();

        return $volunteer->id;
    }

    /**
     * Add a new volunteer to the root unit (administrators only).
     */
    public function addToRootUnit($id): bool
    {
        if (! $this->userService->isAdmin()) {
            return false;
        }

        $root = $this->unitService->getRoot();
        $volunteer = Volunteer::findOrFail($id);

        $this->createMissingSteps($volunteer, $root);
        $this->changeUnitStatus($volunteer->id, $root->id, VolunteerStatus::pending());
        $this->unitHistory($volunteer->id, $root->id);

        return true;
    }

    /**
     * Add a volunteer to a unit.
     *
     * If $unitId is the unit the volunteer is already in ($parentUnitId), the
     * volunteer becomes available there. Otherwise the volunteer joins the
     * unit (and leaves the unit in the request field "parent_unit_id").
     *
     * @return int The volunteer id
     */
    public function addToUnit($unitId, $parentUnitId, $volunteerId): int
    {
        if ($parentUnitId != null && $unitId == $parentUnitId) {
            $this->changeUnitStatus($volunteerId, $unitId, VolunteerStatus::available());

            return (int) $volunteerId;
        }

        $unit = Unit::with('steps')->findOrFail($unitId);
        $volunteer = Volunteer::with('steps')->findOrFail($volunteerId);

        $status = $this->createMissingSteps($volunteer, $unit) || $this->hasIncompleteSteps($volunteer, $unit)
            ? VolunteerStatus::pending()
            : VolunteerStatus::available();

        $leftUnitId = request('parent_unit_id');
        if ($leftUnitId != '') {
            VolunteerUnitStatus::where('volunteer_id', $volunteer->id)->where('unit_id', $leftUnitId)->first()?->delete();
        }

        $this->changeUnitStatus($volunteer->id, $unit->id, $status);
        $this->unitHistory($volunteer->id, $unit->id);

        // the users of the unit get a notification (the administrator, who
        // assigns to the root unit, does not need one)
        if (! $this->unitService->isRoot($unit)) {
            $this->notificationService->newVolunteer($volunteer->id, $unit->id);
        }

        return $volunteer->id;
    }

    /**
     * Add a volunteer to an action: the volunteer becomes active in the unit
     * of the action.
     */
    public function addToAction($volunteer, $action): void
    {
        $this->changeUnitStatus($volunteer->id, $action->unit_id, VolunteerStatus::active());
        $action->volunteers()->attach($volunteer);
        $this->actionHistory($volunteer->id, $action->id);
    }

    /**
     * Remove a volunteer from an action: the volunteer is available again in
     * the unit of the action.
     */
    public function removeFromAction($volunteer, $action): void
    {
        $this->changeUnitStatus($volunteer->id, $action->unit_id, VolunteerStatus::available());
        $volunteer->actions()->detach($action->id);
    }

    /**
     * Save an entry in the action history of a volunteer.
     */
    public function actionHistory($volunteerId, $actionId): void
    {
        (new VolunteerActionHistory([
            'volunteer_id' => $volunteerId,
            'action_id' => $actionId,
            'user_id' => Auth::id(),
            'created' => date('Y-m-d H:i:s'),
        ]))->save();
    }

    /**
     * Give the volunteer the steps of the unit that the volunteer does not
     * have yet, with the status "Incomplete".
     *
     * @return bool True if steps were created
     */
    private function createMissingSteps(Volunteer $volunteer, Unit $unit): bool
    {
        $unitStepIds = $unit->steps->pluck('id')->all();
        $volunteerStepIds = $volunteer->steps->pluck('step_id')->all();
        if (array_diff($unitStepIds, $volunteerStepIds) === []) {
            return false;
        }

        $incomplete = StepStatus::where('description', 'Incomplete')->firstOrFail()->id;
        $volunteer->steps()->saveMany($unit->steps->map(fn ($step) => new VolunteerStepStatus([
            'step_id' => $step->id,
            'step_status_id' => $incomplete,
        ]))->all());

        return true;
    }

    /** The volunteer has steps of the unit that are not complete yet. */
    private function hasIncompleteSteps(Volunteer $volunteer, Unit $unit): bool
    {
        return $volunteer->steps()
            ->whereIn('step_id', $unit->steps->pluck('id')->all())
            ->where('step_status_id', StepStatus::incomplete())
            ->exists();
    }

    private function unitHistory($volunteerId, $unitId): void
    {
        (new VolunteerUnitHistory([
            'volunteer_id' => $volunteerId,
            'unit_id' => $unitId,
            'user_id' => Auth::id(),
            'created' => \Carbon::now(),
        ]))->save();
    }
}
