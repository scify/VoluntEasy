<?php

namespace Tests\Feature;

use App\Models\Descriptions\EducationLevel;
use App\Models\Descriptions\Gender;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Interfaces\ReportsInterface;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

/**
 * Characterization tests of the reports that every deployment flavour has.
 */
class ReportsTest extends TestCase
{
    use RefreshDatabase;

    /** @return array<string, array{class-string}> */
    public static function flavours(): array
    {
        return [
            'scify' => [\Dependencies\scify\services\ReportsService::class],
            'municipality' => [\Dependencies\municipality\services\ReportsService::class],
            'ekpizo' => [\Dependencies\ekpizo\services\ReportsService::class],
        ];
    }

    /** @param class-string $reportsService */
    private function setUpFlavour(string $reportsService): void
    {
        DB::table('genders')->insert([['description' => 'man'], ['description' => 'woman']]);
        DB::table('education_levels')->insert([['description' => 'highschool'], ['description' => 'university']]);
        foreach (['Pending', 'Available', 'Active'] as $status) {
            DB::table('volunteer_statuses')->insert(['description' => $status]);
        }
        $this->app->bind(ReportsInterface::class, $reportsService);

        $man = Gender::where('description', 'man')->value('id');
        $woman = Gender::where('description', 'woman')->value('id');
        $university = EducationLevel::where('description', 'university')->value('id');

        $volunteer = fn (array $fields) => DB::table('volunteers')->insert($fields + [
            'last_name' => 'Doe', 'fathers_name' => '', 'email' => uniqid().'@example.org',
            'created_at' => '2016-03-10 10:00:00', 'updated_at' => '2016-03-10 10:00:00',
        ]);
        $volunteer(['name' => 'A', 'gender_id' => $man, 'city' => 'Athens', 'birth_date' => '1990-05-01', 'education_level_id' => $university]);
        $volunteer(['name' => 'B', 'gender_id' => $woman, 'city' => 'Athens', 'birth_date' => '1950-05-01', 'education_level_id' => $university]);
        $volunteer(['name' => 'C', 'gender_id' => $woman, 'city' => 'Patra', 'birth_date' => '2015-01-01']);
        // A volunteer without a birth date must not break the age report.
        $volunteer(['name' => 'D', 'gender_id' => null, 'city' => null, 'birth_date' => null]);

        $user = new User(['name' => 'Admin', 'email' => 'admin@example.org', 'password' => 'x', 'addr' => '', 'tel' => '', 'image_name' => '']);
        $user->save();
        $this->actingAs($user);
    }

    /** @param class-string $reportsService */
    #[DataProvider('flavours')]
    public function test_volunteers_by_sex(string $reportsService): void
    {
        $this->setUpFlavour($reportsService);

        $this->getJson('/reports/volunteersBySex')->assertOk()->assertExactJson(['men' => 1, 'women' => 2]);
    }

    /** @param class-string $reportsService */
    #[DataProvider('flavours')]
    public function test_volunteers_by_city(string $reportsService): void
    {
        $this->setUpFlavour($reportsService);

        $response = $this->getJson('/reports/volunteersByCity')->assertOk();

        $this->assertEqualsCanonicalizing(
            ['Athens' => 2, 'Patra' => 1],
            collect($response->json())->mapWithKeys(fn ($row, $key) => is_array($row) ? [$row['city'] ?? $key => $row['count'] ?? $row] : [$key => $row])->all(),
        );
    }

    /** @param class-string $reportsService */
    #[DataProvider('flavours')]
    public function test_volunteers_by_education_level(string $reportsService): void
    {
        $this->setUpFlavour($reportsService);

        $counts = collect($this->getJson('/reports/volunteersByEducationLevel')->assertOk()->json())
            ->pluck('count', 'id');

        $this->assertSame(2, $counts[EducationLevel::where('description', 'university')->value('id')]);
        $this->assertSame(3, $counts->sum() + 1, 'one volunteer has no education level');
    }

    /** @param class-string $reportsService */
    #[DataProvider('flavours')]
    public function test_volunteers_by_age_group(string $reportsService): void
    {
        $this->setUpFlavour($reportsService);

        $counts = collect($this->getJson('/reports/volunteersByAgeGroup')->assertOk()->json())
            ->pluck('count', 'ageGroup');

        $this->assertSame(1, $counts['<18']);
        $this->assertSame(1, $counts['25-34'] + $counts['35-49'], 'born in 1990');
        $this->assertSame(1, $counts['>65']);
    }

    /** @param class-string $reportsService */
    #[DataProvider('flavours')]
    public function test_volunteers_by_month_returns_years(string $reportsService): void
    {
        $this->setUpFlavour($reportsService);

        $this->getJson('/reports/volunteersByMonth')->assertOk();
    }
}
