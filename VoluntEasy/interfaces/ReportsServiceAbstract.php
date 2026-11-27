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
    public function getViewPath() {
        return $this->configuration->getViewsPath() . '.reports.all';
    }

    /**
     * This classy piece of code is used to calculate the volunteer
     * statuses by month and years.
     *
     * @return array
     */
    public function volunteersByMonth() {

        $this->volunteerStatuses = VolunteerStatus::pluck('description', 'id')->all();

        $years = [];

        $pendingVolunteers = Volunteer::pending()->with('units')->get();

        foreach ($pendingVolunteers as $volunteer) {
            foreach ($volunteer->units as $unit) {
                $month = intval(date("m", strtotime($unit->created_at)));

                $status = VolunteerUnitStatus::where('volunteer_id', $volunteer->id)
                    ->where('unit_id', $unit->id)->first();

                if ($status != null) {
                    if ($this->volunteerStatuses[$status->volunteer_status_id] == 'Pending') {
                        $year = (date("Y", strtotime($unit->created_at)));
                        if (!array_key_exists($year, $years)) {
                            $years[$year]['pending'] = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
                            $years[$year]['new'] = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
                            $years[$year]['active'] = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
                            $years[$year]['available'] = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
                        }
                        $years[$year]['pending'][$month - 1]++;
                    }
                }
            }
        }

        $availableVolunteers = Volunteer::available()->with('unitsStatus')->get();

        foreach ($availableVolunteers as $volunteer) {
            foreach ($volunteer->units as $unit) {
                $month = intval(date("m", strtotime($unit->created_at)));

                $status = VolunteerUnitStatus::where('volunteer_id', $volunteer->id)
                    ->where('unit_id', $unit->id)->first();

                if ($status != null) {
                    if ($this->volunteerStatuses[$status->volunteer_status_id] == 'Available') {
                        $year = (date("Y", strtotime($unit->created_at)));
                        if (!array_key_exists($year, $years)) {
                            $years[$year]['pending'] = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
                            $years[$year]['new'] = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
                            $years[$year]['active'] = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
                            $years[$year]['available'] = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
                        }
                        $years[$year]['available'][$month - 1]++;
                    }
                }
            }
        }

        $activeVolunteers = Volunteer::active()->with('unitsStatus')->get();

        foreach ($activeVolunteers as $volunteer) {
            foreach ($volunteer->units as $unit) {
                $month = intval(date("m", strtotime($unit->created_at)));

                $status = VolunteerUnitStatus::where('volunteer_id', $volunteer->id)
                    ->where('unit_id', $unit->id)->first();

                if ($status != null) {
                    if ($this->volunteerStatuses[$status->volunteer_status_id] == 'Active') {
                        $year = (date("Y", strtotime($unit->created_at)));
                        if (!array_key_exists($year, $years)) {
                            $years[$year]['pending'] = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
                            $years[$year]['new'] = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
                            $years[$year]['active'] = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
                            $years[$year]['available'] = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
                        }
                        $years[$year]['active'][$month - 1]++;
                    }
                }
            }
        }

        $allVolunteers = Volunteer::all();

        foreach ($allVolunteers as $volunteer) {
            $month = intval(date("m", strtotime($volunteer->created_at)));
            $year = (date("Y", strtotime($volunteer->created_at)));

            if (!array_key_exists($year, $years)) {
                $years[$year]['pending'] = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
                $years[$year]['new'] = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
                $years[$year]['active'] = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
                $years[$year]['available'] = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
            }

            $years[$year]['new'][$month - 1]++;
        }

        return ($years);
    }

    public function volunteersByAgeGroup() {
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
            //get volunteer's age
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

    public function volunteersBySex() {

        $manId = Gender::where('description', 'man')->first()->id;
        $womanId = Gender::where('description', 'woman')->first()->id;

        $men = Volunteer::where('gender_id', $manId)->count();
        $women = Volunteer::where('gender_id', $womanId)->count();

        return [
            'men' => $men,
            'women' => $women
        ];
    }

    public function volunteersByCity() {
        $volunteers = Volunteer::get(['city']);

        $byCity = [];

        //count volunteers by city
        foreach ($volunteers as $volunteer) {
            if ($volunteer->city != null) {
                if (array_key_exists($volunteer->city, $byCity))
                    $byCity[$volunteer->city] = $byCity[$volunteer->city] + 1;
                else
                    $byCity[$volunteer->city] = 1;
            }
        }

        //return volunteers array in a more appropriate form
        $volunteers = [];
        foreach ($byCity as $key => $bc) {
            array_push($volunteers, [
                'city' => $key,
                'count' => $bc
            ]);
        }
        return $volunteers;
    }

    public function volunteersByEducationLevel() {
        $educationLevels = EducationLevel::all();
        $volunteers = Volunteer::get(['education_level_id']);

        foreach ($educationLevels as $educationLevel) {
            $educationLevel->count = 0;
        }

        //count volunteers by city
        foreach ($volunteers as $volunteer) {
            foreach ($educationLevels as $educationLevel) {
                if ($volunteer->education_level_id == $educationLevel->id)
                    $educationLevel->count++;
            }
        }

        return $educationLevels;
    }

    public function volunteerHoursByAction() {

        $dbactions = Action::with('ratings.volunteerRatings.volunteer')->get();

        //  return $dbactions;

        $actions = [];
        foreach ($dbactions as $action) {

            $volunteers = [];
            $totalHours = 0;
            $totalMinutes = 0;
            //get only the actions that have ratings
            if (sizeof($action->ratings) > 0) {

                foreach ($action->ratings as $rating) {
                    if ($rating->rated) {

                        $totalHours = 0;
                        $totalMinutes = 0;

                        foreach ($rating->volunteerRatings as $volunteer) {

                            $hours = 0;
                            $minutes = 0;

                            if ($volunteer->hours > 9)
                                $hours = $volunteer->hours;
                            else
                                $hours = '0' . $volunteer->hours;

                            if ($volunteer->minutes > 9)
                                $minutes = $volunteer->minutes;
                            else
                                $minutes = '0' . $volunteer->minutes;

                            $totalHours += $volunteer->hours;
                            $totalMinutes += $volunteer->minutes;

                            array_push($volunteers, [
                                'id' => $volunteer->volunteer->id,
                                'name' => $volunteer->volunteer->name . ' ' . $volunteer->volunteer->last_name,
                                'hours' => $hours . ':' . $minutes,
                            ]);
                        }
                    }
                }

                if ($totalHours != 0 && $totalMinutes != 0) {
                    if ($totalMinutes > 59) {
                        $totalHours += intval($totalMinutes / 60);
                        $totalMinutes = $totalMinutes % 60;
                    }
                }

                array_push($actions, [
                    'id' => $action->id,
                    'description' => $action->description,
                    'volunteers' => $volunteers,
                    'totalHours' => $totalHours . ':' . $totalMinutes
                ]);
            }
        }

        return $actions;

    }
}
