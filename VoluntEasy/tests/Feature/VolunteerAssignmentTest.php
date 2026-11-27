<?php

namespace Tests\Feature;

use App\Models\Action;
use App\Models\Descriptions\VolunteerStatus;
use App\Models\Unit;
use App\Models\User;
use App\Models\Volunteer;
use App\Services\UnitService;
use App\Services\Volunteers\VolunteerAssignment;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

/**
 * Adding volunteers to units and actions, and their status in each unit.
 */
class VolunteerAssignmentTest extends TestCase
{
    use RefreshDatabase;

    private Unit $root;

    private Unit $child;

    private Volunteer $volunteer;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(DatabaseSeeder::class);
        $this->actingAs(User::where('email', 'test@scify.org')->firstOrFail());

        $this->root = Unit::whereNull('parent_unit_id')->firstOrFail();
        $this->child = Unit::create(['description' => 'Athens branch', 'comments' => '', 'level' => 1, 'parent_unit_id' => $this->root->id]);
        $this->child->steps()->saveMany(app(UnitService::class)->createSteps());

        $this->volunteer = new Volunteer(['name' => 'Kostas', 'last_name' => 'P', 'fathers_name' => '', 'email' => 'kostas@example.org']);
        $this->volunteer->save();
    }

    private function assignment(): object
    {
        return app(VolunteerAssignment::class);
    }

    private function statusIn(Unit $unit): ?int
    {
        $id = DB::table('volunteer_unit_status')->whereNull('deleted_at')
            ->where('volunteer_id', $this->volunteer->id)->where('unit_id', $unit->id)->value('volunteer_status_id');

        return $id === null ? null : (int) $id;
    }

    public function test_adding_to_the_root_unit_makes_the_volunteer_pending_with_incomplete_steps(): void
    {
        $this->assertTrue($this->assignment()->addToRootUnit($this->volunteer->id));

        $this->assertSame(VolunteerStatus::pending(), $this->statusIn($this->root));
        $this->assertSame($this->root->steps()->count(), $this->volunteer->steps()->count());
        $this->assertSame(1, DB::table('volunteer_unit_history')->where('volunteer_id', $this->volunteer->id)->count());
    }

    public function test_moving_to_a_child_unit_leaves_the_parent_unit(): void
    {
        $this->assignment()->addToRootUnit($this->volunteer->id);
        request()->merge(['parent_unit_id' => $this->root->id]);

        $this->assignment()->addToUnit($this->child->id, $this->root->id, $this->volunteer->id);

        $this->assertNull($this->statusIn($this->root));
        $this->assertSame(VolunteerStatus::pending(), $this->statusIn($this->child));
        $this->assertSame(2, DB::table('volunteer_unit_history')->where('volunteer_id', $this->volunteer->id)->count());
    }

    public function test_assigning_in_the_same_unit_makes_the_volunteer_available(): void
    {
        $this->assignment()->addToRootUnit($this->volunteer->id);

        $this->assignment()->addToUnit($this->root->id, $this->root->id, $this->volunteer->id);

        $this->assertSame(VolunteerStatus::available(), $this->statusIn($this->root));
    }

    public function test_a_volunteer_in_an_action_is_active_and_available_again_when_removed(): void
    {
        $this->assignment()->addToUnit($this->child->id, $this->child->id, $this->volunteer->id);
        $action = Action::create(['description' => 'Run', 'unit_id' => $this->child->id, 'start_date' => '2030-01-01', 'end_date' => '2030-01-02', 'comments' => '']);

        $this->assignment()->addToAction($this->volunteer, $action);
        $this->assertSame(VolunteerStatus::active(), $this->statusIn($this->child));
        $this->assertSame(1, $action->volunteers()->count());
        $this->assertSame(1, DB::table('volunteer_action_history')->where('volunteer_id', $this->volunteer->id)->count());

        $this->assignment()->removeFromAction($this->volunteer, $action);
        $this->assertSame(VolunteerStatus::available(), $this->statusIn($this->child));
        $this->assertSame(0, $action->volunteers()->count());
    }

    public function test_a_not_available_volunteer_becomes_available(): void
    {
        $this->volunteer->update(['not_available' => true]);
        $durationId = DB::table('volunteer_status_duration')->insertGetId([
            'volunteer_id' => $this->volunteer->id, 'status_id' => VolunteerStatus::notAvailable(),
            'from_date' => '2030-01-01', 'to_date' => '2030-02-01', 'comments' => '',
        ]);

        $this->assertSame($this->volunteer->id, (int) $this->assignment()->setVolunteerToAvailable($durationId));
        $this->assertFalse((bool) $this->volunteer->fresh()->not_available);
    }
}
