<?php namespace Dependencies\ekpizo\services;

use App\Models\Descriptions\AvailabilityDay;
use App\Models\Descriptions\Language;
use App\Models\Volunteer;
use App\Models\VolunteerExtras;
use App\Models\VolunteerLanguage;
use App\Services\Facades\NotificationService;
use App\Services\Facades\UnitService;
use Interfaces\StandardVolunteerService;

/**
 * The ekpizo flavour: the standard volunteer form, plus apiStore() that
 * receives the volunteer form of the ekpizo.gr web site.
 */
class VolunteerServiceImpl extends StandardVolunteerService {

    /** Form field => language description in the "languages" table. */
    private const LANGUAGE_FIELDS = [
        'langGR' => 'greek',
        'langEN' => 'english',
        'langFR' => 'french',
        'langSP' => 'spanish',
        'langDE' => 'german',
    ];

    /** Time-of-day value of the "contr_days" checkboxes. */
    private const TIMES_OF_DAY = ['1' => 'morning', '2' => 'afternoon', '3' => 'evening'];

    private const WEEK_DAYS = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];

    /**
     * Save a volunteer sent by the volunteer form of the ekpizo.gr web site
     * (request field "submitted").
     *
     * @return \Illuminate\Http\JsonResponse 201 with the volunteer, or 200 with an error code (see validateInput)
     */
    public function apiStore() {
        $data = (array) \Request::input('submitted', []);

        $errorCode = $this->validateInput($data);
        if ($errorCode !== 0) {
            return \Response::json($errorCode, 200);
        }

        $volunteer = new Volunteer($this->volunteerFields($data));
        $birthDate = $this->birthDate($data);
        if ($birthDate !== null) {
            $volunteer->birth_date = $birthDate;
        }
        $volunteer->save();

        $volunteer->extras()->save($this->extras($data));
        $this->saveLanguages($volunteer, $data);
        $volunteer->interests()->sync(data_get($data, 'avail_Inter.interests', []));
        if (data_get($data, 'volunteering.department') !== null) {
            $volunteer->volunteeringDepartments()->sync(data_get($data, 'volunteering.department'));
        }
        $this->saveAvailability($volunteer, (array) data_get($data, 'avail_Inter', []));

        NotificationService::newVolunteer($volunteer->id, UnitService::getRoot()->id);

        return \Response::json($volunteer, 201);
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    private function volunteerFields(array $data): array
    {
        $field = fn (string $path) => data_get($data, $path, '');
        $dropDown = fn (string $path) => $this->checkDropDown(data_get($data, $path, 0));

        return [
            'name' => $field('volunteer_info.name'),
            'last_name' => $field('volunteer_info.last_name'),
            'fathers_name' => $field('volunteer_info.fathers_name'),
            'city' => $field('volunteer_info.city'),
            'country' => $field('volunteer_info.country'),
            'gender_id' => $dropDown('volunteer_info.gender_id'),
            'driver_license_type_id' => $dropDown('volunteer_info.driver_license_type_id'),
            'home_tel' => $field('volunteer_info.home_tel'),
            'cell_tel' => $field('volunteer_info.cell_tel'),
            'email' => $field('volunteer_info.email'),
            'education_level_id' => $dropDown('education.education_level_id'),
            'specialty' => $field('education.specialty'),
            'additional_skills' => $field('education.additional_skills'),
            'computer_usage_comments' => $field('education.computer_usage_comments'),
            'extra_lang' => $field('education.languages.extra_lang'),
            'availability_freqs_id' => $dropDown('avail_Inter.availability_freqs_id'),
            'work_description' => $field('work_exper.job_experience_comments'),
            'participation_actions' => $field('work_exper.vol_experience_area'),
            'how_you_learned_id' => $dropDown('extra_comments.howYouLearned'),
            'how_you_learned2_id' => $dropDown('extra_comments.how_did_you_learn'),
        ];
    }

    /** @param array<string, mixed> $data */
    private function birthDate(array $data): ?\Carbon\Carbon
    {
        $date = (array) data_get($data, 'volunteer_info.birth_date', []);
        if (empty($date['year']) || empty($date['month']) || empty($date['day'])) {
            return null;
        }

        return \Carbon::createFromDate($date['year'], $date['month'], $date['day']);
    }

    /** @param array<string, mixed> $data */
    private function extras(array $data): VolunteerExtras
    {
        $checked = fn (string $path) => data_get($data, $path) == 1;

        $extras = new VolunteerExtras();
        foreach ([
            'knows_word' => 'education.office.office_word',
            'knows_excel' => 'education.office.office_excel',
            'knows_powerpoint' => 'education.office.office_powerpoint',
            'has_previous_volunteer_experience' => 'work_exper.vol_experience',
            'has_previous_work_experience' => 'work_exper.job_experience',
        ] as $column => $path) {
            if ($checked($path)) {
                $extras->{$column} = true;
            }
        }
        $extras->other_department = data_get($data, 'volunteering.other_department', '');

        return $extras;
    }

    /** @param array<string, mixed> $data */
    private function saveLanguages(Volunteer $volunteer, array $data): void
    {
        foreach (self::LANGUAGE_FIELDS as $field => $language) {
            $level = data_get($data, "education.languages.{$field}");
            if ($level !== null) {
                $volunteer->languages()->save(new VolunteerLanguage([
                    'volunteer_id' => $volunteer->id,
                    'language_id' => Language::where('description', $language)->value('id'),
                    'language_level_id' => $level,
                ]));
            }
        }
    }

    /**
     * Frequency "1" (daily) stores times of day; other frequencies store
     * days of the week with a time of day.
     *
     * @param  array<string, mixed>  $availability
     */
    private function saveAvailability(Volunteer $volunteer, array $availability): void
    {
        $frequency = (string) ($availability['availability_freqs_id'] ?? '');
        if ($frequency === '') {
            return;
        }

        if ($frequency === '1') {
            if (! empty($availability['dailyFrequencies'])) {
                $volunteer->availabilityTimes()->sync($availability['dailyFrequencies']);
            }

            return;
        }

        foreach (self::WEEK_DAYS as $weekDay) {
            foreach ((array) ($availability['contr_days'][$weekDay] ?? []) as $timeOfDay) {
                (new AvailabilityDay([
                    'day' => $weekDay,
                    'time' => self::TIMES_OF_DAY[(string) $timeOfDay] ?? '',
                    'volunteer_id' => $volunteer->id,
                ]))->save();
            }
        }
    }

    private function checkDropDown($input) {
        return $input == 0 ? null : $input;
    }

    /**
     * Validate the form before saving. The ekpizo.gr site shows a message
     * for each error code.
     *
     * @param  array<string, mixed>  $data
     * @return int 101 no name, 102 no last name, 103 no birth date, 104 no
     *             interests, 201 invalid e-mail, 202 e-mail exists, 0 valid
     */
    private function validateInput(array $data): int
    {
        $email = (string) data_get($data, 'volunteer_info.email', '');

        return match (true) {
            data_get($data, 'volunteer_info.name', '') == '' => 101,
            data_get($data, 'volunteer_info.last_name', '') == '' => 102,
            $this->birthDate($data) === null => 103,
            empty(data_get($data, 'avail_Inter.interests')) => 104,
            ! filter_var($email, FILTER_VALIDATE_EMAIL) => 201,
            Volunteer::where('email', $email)->exists() => 202,
            default => 0,
        };
    }
}
