<?php

namespace Tests\Feature;

use App\Models\Action;
use App\Models\Collaboration;
use App\Models\Unit;
use App\Models\User;
use App\Models\Volunteer;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Support\SubmitsForms;
use Tests\TestCase;

/**
 * The main create and edit flows, submitted through the real forms.
 */
class CrudFlowsTest extends TestCase
{
    use RefreshDatabase;
    use SubmitsForms;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(DatabaseSeeder::class);
        $this->actingAs(User::where('email', 'test@scify.org')->firstOrFail());
    }

    public function test_create_and_edit_a_volunteer(): void
    {
        $this->submitForm('/volunteers/create', [
            'name' => 'Maria', 'last_name' => 'Papadopoulou', 'email' => 'maria@example.org',
            'birth_date' => '01/02/1990', 'cell_tel' => '6900000000', 'city' => 'Athens',
            'participation_reason' => 'To help', 'lang' => [2 => 3], 'departments' => [1],
        ])->assertSessionHasNoErrors();

        $volunteer = Volunteer::where('email', 'maria@example.org')->firstOrFail();
        $this->assertSame('01/02/1990', $volunteer->birth_date);
        $this->assertSame(1, $volunteer->languages()->count());

        $this->submitForm("/volunteers/edit/{$volunteer->id}", ['name' => 'Marianna'])
            ->assertRedirect("/volunteers/one/{$volunteer->id}");
        $this->assertSame('Marianna', $volunteer->fresh()->name);

        $this->get("/volunteers/one/{$volunteer->id}")->assertOk()->assertSee('Marianna');
    }

    public function test_the_availability_days_are_saved_for_every_day(): void
    {
        // Thursday was sent as ".thursday[]" and never saved.
        $this->get('/volunteers/create')->assertSee('name="thursday[]"', false)->assertDontSee('name=".thursday[]"', false);

        $this->submitForm('/volunteers/create', [
            'name' => 'Petros', 'last_name' => 'D', 'email' => 'petros@example.org', 'birth_date' => '01/02/1990',
            'cell_tel' => '6900000001', 'city' => 'Athens', 'participation_reason' => 'x',
            'availability_freqs_id' => '2', 'monday' => ['1'], 'thursday' => ['2', '3'],
        ])->assertSessionHasNoErrors();

        $volunteer = Volunteer::where('email', 'petros@example.org')->firstOrFail();
        $this->assertEqualsCanonicalizing(
            ['monday morning', 'thursday afternoon', 'thursday evening'],
            $volunteer->availabilityDays()->get()->map(fn ($day) => "{$day->day} {$day->time}")->all(),
        );
    }

    public function test_create_and_edit_an_action(): void
    {
        $unit = Unit::firstOrFail();

        $this->submitForm('/actions/create', [
            'description' => 'Beach cleaning', 'unit_id' => $unit->id,
            'start_date' => '01/06/2030', 'end_date' => '30/06/2030',
        ])->assertSessionHasNoErrors()->assertRedirect();

        $action = Action::where('description', 'Beach cleaning')->firstOrFail();

        $this->submitForm("/actions/edit/{$action->id}", ['description' => 'Park cleaning'])
            ->assertSessionHasNoErrors();
        $this->assertSame('Park cleaning', $action->fresh()->description);

        $this->get("/actions/one/{$action->id}")->assertOk()->assertSee('Park cleaning');
    }

    public function test_create_and_edit_a_user(): void
    {
        $this->submitForm('/users/create', [
            'name' => 'Nikos', 'last_name' => 'K', 'email' => 'nikos@example.org',
            'password' => 'secret123', 'password_confirmation' => 'secret123',
            'addr' => 'Address 1', 'tel' => '2100000000',
        ])->assertSessionHasNoErrors();

        $user = User::where('email', 'nikos@example.org')->firstOrFail();

        $this->submitForm("/users/edit/{$user->id}", ['name' => 'Nikolaos'])->assertSessionHasNoErrors();
        $this->assertSame('Nikolaos', $user->fresh()->name);
    }

    public function test_create_and_edit_a_collaboration(): void
    {
        $this->submitForm('/collaborations/create', [
            'name' => 'Red Cross', 'start_date' => '01/01/2030', 'end_date' => '31/12/2030',
        ])->assertSessionHasNoErrors();

        $collaboration = Collaboration::where('name', 'Red Cross')->firstOrFail();

        $this->submitForm("/collaborations/edit/{$collaboration->id}", ['name' => 'Hellenic Red Cross'])
            ->assertSessionHasNoErrors();
        $this->assertSame('Hellenic Red Cross', $collaboration->fresh()->name);
    }
}
