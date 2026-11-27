<?php

namespace Tests\Feature;

use App\Models\Descriptions\VolunteerStatus;
use App\Models\Unit;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class VolunteerSearchTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(DatabaseSeeder::class);
        $this->actingAs(User::where('email', 'test@scify.org')->firstOrFail());

        $unit = Unit::firstOrFail();
        foreach ([['Anna', '2101111111'], ['Boris', '2102222222'], ['Alexis', '2103333333']] as [$name, $phone]) {
            $id = DB::table('volunteers')->insertGetId([
                'name' => $name, 'last_name' => 'X', 'fathers_name' => '', 'email' => strtolower($name).'@example.org',
                'home_tel' => '', 'work_tel' => $phone, 'cell_tel' => '',
                'blacklisted' => false, 'not_available' => false,
            ]);
            if ($name !== 'Alexis') {
                DB::table('volunteer_unit_status')->insert([
                    'volunteer_id' => $id, 'unit_id' => $unit->id, 'volunteer_status_id' => VolunteerStatus::available(),
                ]);
            }
        }
    }

    /** @return list<string> */
    private function search(array $filters): array
    {
        return collect($this->postJson('/volunteers/search', $filters)->assertOk()->json('data'))
            ->pluck('name')->sort()->values()->all();
    }

    public function test_without_filters_all_volunteers_are_found(): void
    {
        $this->assertSame(['Alexis', 'Anna', 'Boris'], $this->search([]));
    }

    public function test_the_phone_number_matches_any_phone_column(): void
    {
        $this->assertSame(['Boris'], $this->search(['phoneNumber' => '2102222222']));
    }

    public function test_the_status_filter_keeps_the_other_filters(): void
    {
        // Before: the status filter replaced the query, so "A" was ignored.
        $this->assertSame(['Anna'], $this->search(['status_id' => '3', 'name' => 'A']));
    }

    public function test_the_choose_option_of_a_dropdown_does_not_filter(): void
    {
        $this->assertSame(['Alexis', 'Anna', 'Boris'], $this->search(['status_id' => '0', 'gender_id' => '0']));
    }
}
