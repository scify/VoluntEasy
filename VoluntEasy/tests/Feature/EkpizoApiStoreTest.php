<?php

namespace Tests\Feature;

use App\Models\Volunteer;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Interfaces\ConfigurationInterface;
use Interfaces\VolunteerInterface;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

/**
 * The ekpizo.gr web site sends its volunteer form to /api/volunteers/apiStore.
 */
class EkpizoApiStoreTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->app->bind(ConfigurationInterface::class, \Dependencies\ekpizo\configuration\Configuration::class);
        $this->app->bind(VolunteerInterface::class, \Dependencies\ekpizo\services\VolunteerServiceImpl::class);
        $this->seed(DatabaseSeeder::class);
    }

    /** @return array<string, mixed> */
    private function submitted(array $overrides = []): array
    {
        $data = [
            'volunteer_info' => [
                'name' => 'Eleni', 'last_name' => 'Georgiou', 'fathers_name' => 'Giorgos',
                'birth_date' => ['year' => '1985', 'month' => '7', 'day' => '15'],
                'city' => 'Athens', 'country' => 'Greece', 'gender_id' => '2', 'driver_license_type_id' => '0',
                'home_tel' => '2100000000', 'cell_tel' => '6900000000', 'email' => 'eleni@example.org',
            ],
            'education' => [
                'education_level_id' => '1', 'specialty' => 'Law', 'additional_skills' => 'Typing',
                'computer_usage_comments' => '', 'office' => ['office_word' => '1', 'office_excel' => '0'],
                'languages' => ['extra_lang' => 'Italian', 'langGR' => '3', 'langEN' => '2'],
            ],
            'avail_Inter' => [
                'interests' => ['1', '2'], 'availability_freqs_id' => '2',
                'contr_days' => ['monday' => ['1', '3'], 'friday' => ['2']],
            ],
            'work_exper' => ['job_experience_comments' => 'Office work', 'vol_experience_area' => 'Elderly', 'vol_experience' => '1'],
            'volunteering' => ['other_department' => 'Events', 'department' => ['1']],
            'extra_comments' => ['howYouLearned' => '1', 'how_did_you_learn' => '0'],
        ];

        return array_replace_recursive($data, $overrides);
    }

    public function test_a_complete_form_creates_the_volunteer(): void
    {
        $this->postJson('/api/volunteers/apiStore', ['submitted' => $this->submitted()])->assertCreated();

        $volunteer = Volunteer::where('email', 'eleni@example.org')->firstOrFail();
        $this->assertSame('15/07/1985', $volunteer->birth_date);
        $this->assertNull($volunteer->driver_license_type_id, '"0" means nothing chosen');
        $this->assertTrue((bool) $volunteer->extras->knows_word);
        $this->assertFalse((bool) $volunteer->extras->knows_excel);
        $this->assertTrue((bool) $volunteer->extras->has_previous_volunteer_experience);
        $this->assertSame(2, $volunteer->languages()->count());
        $this->assertSame(['1', '2'], $volunteer->interests()->pluck('interest_id')->map(fn ($id) => (string) $id)->all());
        $this->assertSame(1, $volunteer->volunteeringDepartments()->count());
        $this->assertEqualsCanonicalizing(
            ['monday morning', 'monday evening', 'friday afternoon'],
            DB::table('availability_days')->where('volunteer_id', $volunteer->id)->get()->map(fn ($d) => "{$d->day} {$d->time}")->all(),
        );
    }

    public function test_daily_availability_uses_the_time_of_day(): void
    {
        $this->postJson('/api/volunteers/apiStore', ['submitted' => $this->submitted([
            'avail_Inter' => ['availability_freqs_id' => '1', 'dailyFrequencies' => ['1', '2']],
        ])])->assertCreated();

        $volunteer = Volunteer::where('email', 'eleni@example.org')->firstOrFail();
        $this->assertSame(2, $volunteer->availabilityTimes()->count());
    }

    /** @return array<string, array{array<string, mixed>, int}> */
    public static function invalidForms(): array
    {
        return [
            'no name' => [['volunteer_info' => ['name' => '']], 101],
            'no last name' => [['volunteer_info' => ['last_name' => '']], 102],
            'no birth year' => [['volunteer_info' => ['birth_date' => ['year' => '']]], 103],
            'no interests' => [['avail_Inter' => ['interests' => []]], 104],
            'invalid e-mail' => [['volunteer_info' => ['email' => 'not-an-email']], 201],
        ];
    }

    #[DataProvider('invalidForms')]
    public function test_an_invalid_form_returns_an_error_code(array $overrides, int $code): void
    {
        $submitted = $this->submitted($overrides);
        if ($overrides === ['avail_Inter' => ['interests' => []]]) {
            $submitted['avail_Inter']['interests'] = [];
        }

        $this->postJson('/api/volunteers/apiStore', ['submitted' => $submitted])->assertOk()->assertExactJson([$code]);
        $this->assertSame(0, Volunteer::count());
    }

    public function test_an_e_mail_that_exists_returns_202(): void
    {
        $this->postJson('/api/volunteers/apiStore', ['submitted' => $this->submitted()])->assertCreated();

        $this->postJson('/api/volunteers/apiStore', ['submitted' => $this->submitted()])->assertOk()->assertExactJson([202]);
    }

    public function test_english_is_saved_without_greek(): void
    {
        // Before: English was saved only when Greek was also sent.
        $submitted = $this->submitted();
        $submitted['education']['languages'] = ['extra_lang' => '', 'langEN' => '2'];

        $this->postJson('/api/volunteers/apiStore', ['submitted' => $submitted])->assertCreated();

        $english = DB::table('languages')->where('description', 'english')->value('id');
        $this->assertEquals([$english], Volunteer::firstOrFail()->languages()->pluck('language_id')->all());
    }
}
