<?php

namespace Interfaces;

use App\Models\Action;
use App\Models\Descriptions\EducationLevel;
use App\Models\Descriptions\Gender;
use App\Models\Descriptions\VolunteerStatus;
use App\Models\Volunteer;
use App\Models\VolunteerUnitStatus;

/**
 * The reports that all deployment flavours share.
 *
 * A flavour (dependencies/<mode>/services/ReportsService) extends this class,
 * adds or overrides reports. The reports page comes from the views of the flavour.
 */
abstract class ReportsServiceAbstract implements ReportsInterface
{
    /** @var array<int, string> Status descriptions by status id. */
    protected array $volunteerStatuses = [];

    public function __construct(private readonly ConfigurationInterface $configuration) {}

    /**
     * The reports page of the current flavour.
     */
    public function getViewPath()
    {
        return $this->configuration->getViewsPath().'.reports.all';
    }

    /**
     * For each year, the number of volunteers per month: new volunteers (by
     * creation date) and volunteers that are pending, available or active
     * in a unit (by the date of the unit).
     *
     * @return array<string, array{pending: list<int>, new: list<int>, active: list<int>, available: list<int>}>
     */
    public function volunteersByMonth()
    {
        $this->volunteerStatuses = VolunteerStatus::pluck('description', 'id')->all();
        $years = [];

        // status scope and series => status description
        foreach (['pending' => 'Pending', 'available' => 'Available', 'active' => 'Active'] as $series => $description) {
            foreach (Volunteer::{$series}()->with('units')->get() as $volunteer) {
                foreach ($volunteer->units as $unit) {
                    if ($this->statusInUnit($volunteer->id, $unit->id) === $description) {
                        $this->countInMonth($years, $series, $unit->created_at);
                    }
                }
            }
        }

        foreach (Volunteer::all() as $volunteer) {
            $this->countInMonth($years, 'new', $volunteer->created_at);
        }

        return $years;
    }

    /** The description of the volunteer's current status in the unit. */
    private function statusInUnit(int $volunteerId, int $unitId): ?string
    {
        $statusId = VolunteerUnitStatus::where('volunteer_id', $volunteerId)->where('unit_id', $unitId)->value('volunteer_status_id');

        return $statusId === null ? null : ($this->volunteerStatuses[$statusId] ?? null);
    }

    /**
     * @param  array<int|string, array<string, array<int, int>>>  $years
     */
    private function countInMonth(array &$years, string $series, mixed $date): void
    {
        $time = strtotime((string) $date);
        $year = date('Y', $time);
        $years[$year] ??= [
            'pending' => array_fill(0, 12, 0),
            'new' => array_fill(0, 12, 0),
            'active' => array_fill(0, 12, 0),
            'available' => array_fill(0, 12, 0),
        ];
        $years[$year][$series][(int) date('m', $time) - 1]++;
    }

    public function volunteersByAgeGroup()
    {
        // age groups:  18-24, 25-34, 35-49, 50-64, 65+

        $ageGroups = [
            ['ageGroup' => '<18',
                'count' => 0],
            ['ageGroup' => '18-24',
                'count' => 0],
            ['ageGroup' => '25-34',
                'count' => 0],
            ['ageGroup' => '35-49',
                'count' => 0],
            ['ageGroup' => '50-64',
                'count' => 0],
            ['ageGroup' => '>65',
                'count' => 0]];

        $volunteers = Volunteer::get(['birth_date']);

        foreach ($volunteers as $volunteer) {
            // get volunteer's age
            if ($volunteer->birth_date != null) {
                $birth_date = \Carbon::createFromFormat('d/m/Y', $volunteer->birth_date);
                $age = \Carbon::createFromDate($birth_date->year, $birth_date->month, $birth_date->day)->age;

                foreach ($ageGroups as $key => $ageGroup) {

                    if ($age < 18 && $ageGroup['ageGroup'] == '<18') {
                        $ageGroups[$key]['count']++;
                    }
                    if ($age >= 18 && $age <= 24 && $ageGroup['ageGroup'] == '18-24') {
                        $ageGroups[$key]['count']++;
                    }
                    if ($age >= 25 && $age <= 34 && $ageGroup['ageGroup'] == '25-34') {
                        $ageGroups[$key]['count']++;
                    }
                    if ($age >= 35 && $age <= 49 && $ageGroup['ageGroup'] == '35-49') {
                        $ageGroups[$key]['count']++;
                    }
                    if ($age >= 50 && $age <= 64 && $ageGroup['ageGroup'] == '50-64') {
                        $ageGroups[$key]['count']++;
                    }
                    if ($age >= 65 && $ageGroup['ageGroup'] == '>65') {
                        $ageGroups[$key]['count']++;
                    }
                }
            }
        }

        return $ageGroups;
    }

    public function volunteersBySex()
    {

        $manId = Gender::where('description', 'man')->first()->id;
        $womanId = Gender::where('description', 'woman')->first()->id;

        $men = Volunteer::where('gender_id', $manId)->count();
        $women = Volunteer::where('gender_id', $womanId)->count();

        return [
            'men' => $men,
            'women' => $women,
        ];
    }

    public function volunteersByCity()
    {
        $volunteers = Volunteer::get(['city']);

        $byCity = [];

        // count volunteers by city
        foreach ($volunteers as $volunteer) {
            if ($volunteer->city != null) {
                if (array_key_exists($volunteer->city, $byCity)) {
                    $byCity[$volunteer->city] = $byCity[$volunteer->city] + 1;
                } else {
                    $byCity[$volunteer->city] = 1;
                }
            }
        }

        // return volunteers array in a more appropriate form
        $volunteers = [];
        foreach ($byCity as $key => $bc) {
            array_push($volunteers, [
                'city' => $key,
                'count' => $bc,
            ]);
        }

        return $volunteers;
    }

    public function volunteersByEducationLevel()
    {
        $educationLevels = EducationLevel::all();
        $volunteers = Volunteer::get(['education_level_id']);

        foreach ($educationLevels as $educationLevel) {
            $educationLevel->count = 0;
        }

        // count volunteers by city
        foreach ($volunteers as $volunteer) {
            foreach ($educationLevels as $educationLevel) {
                if ($volunteer->education_level_id == $educationLevel->id) {
                    $educationLevel->count++;
                }
            }
        }

        return $educationLevels;
    }

    /**
     * The hours of each volunteer in each action, from the rated volunteer
     * ratings ("hours" is "HH:MM"; "totalHours" is "H:M" for all ratings).
     *
     * @return list<array<string, mixed>>
     */
    public function volunteerHoursByAction()
    {
        $actions = [];
        foreach (Action::with('ratings.volunteerRatings.volunteer')->get() as $action) {
            if ($action->ratings->isEmpty()) {
                continue;
            }

            $volunteers = [];
            $totalMinutes = 0;
            foreach ($action->ratings as $rating) {
                if (! $rating->rated) {
                    continue;
                }
                foreach ($rating->volunteerRatings as $volunteerRating) {
                    $totalMinutes += 60 * (int) $volunteerRating->hours + (int) $volunteerRating->minutes;
                    $volunteers[] = [
                        'id' => $volunteerRating->volunteer->id,
                        'name' => $volunteerRating->volunteer->name.' '.$volunteerRating->volunteer->last_name,
                        'hours' => $this->twoDigits($volunteerRating->hours).':'.$this->twoDigits($volunteerRating->minutes),
                    ];
                }
            }

            $actions[] = [
                'id' => $action->id,
                'description' => $action->description,
                'volunteers' => $volunteers,
                'totalHours' => intdiv($totalMinutes, 60).':'.($totalMinutes % 60),
            ];
        }

        return $actions;
    }

    private function twoDigits(mixed $value): string
    {
        return $value > 9 ? (string) $value : '0'.$value;
    }
}
