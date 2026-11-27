<?php

namespace App\Services\Volunteers;

use App\Models\Volunteer;
use App\Services\Facades\SearchService as Search;
use App\Services\Facades\VolunteerService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

/**
 * The volunteer search of the volunteers list page.
 *
 * Each request field is a filter. Dropdowns send "0" when nothing is chosen.
 */
class VolunteerSearch
{
    /** Text filters: the column starts with the value. */
    private const STARTS_WITH = ['name', 'last_name'];

    /** Text filters: the column contains the value. */
    private const CONTAINS = [
        'additional_skills', 'work_description', 'specialty', 'department',
        'participation_actions', 'computer_usage_comments', 'extra_lang',
    ];

    /** Filters on the exact value of a column (most are dropdowns). */
    private const EQUALS = [
        'email', 'marital_status_id', 'gender_id', 'work_status_id', 'education_level_id',
        'city', 'country', 'computer_usage',
    ];

    /** Status dropdown value => Volunteer query scope. */
    private const STATUS_SCOPES = [
        '1' => 'unassigned',
        '2' => 'pending',
        '3' => 'available',
        '4' => 'active',
        '5' => 'notAvailable',
        '6' => 'blacklisted',
    ];

    /**
     * @return array{data: array<int, Volunteer>}
     */
    public function search(Request $request): array
    {
        $query = Volunteer::query();

        if ($request->filled('my_volunteers')) {
            $query->whereIn('id', VolunteerService::permittedVolunteersIds());
        }

        $this->filterByStatus($query, $request);
        $this->filterByText($query, $request);
        $this->filterByAgeRange($query, $request);
        $this->filterByPhoneNumber($query, $request);
        $this->filterByRelations($query, $request);

        if ($request->filled('contract_date')) {
            $query->whereNotNull('contract_date');
        }

        $volunteers = $query->orderBy('name', 'asc')->with('actions', 'units')->get();

        return ['data' => VolunteerService::prepareForDataTable($volunteers)];
    }

    /** @param Builder<Volunteer> $query */
    private function filterByStatus(Builder $query, Request $request): void
    {
        $scope = self::STATUS_SCOPES[(string) $request->input('status_id')] ?? null;
        if ($scope !== null) {
            $query->{$scope}();
        }
    }

    /** @param Builder<Volunteer> $query */
    private function filterByText(Builder $query, Request $request): void
    {
        foreach (self::STARTS_WITH as $column) {
            if ($request->filled($column)) {
                $query->where($column, 'like', $request->input($column).'%');
            }
        }

        foreach (self::CONTAINS as $column) {
            if ($request->filled($column)) {
                $query->where($column, 'like', '%'.$request->input($column).'%');
            }
        }

        foreach (self::EQUALS as $column) {
            $value = $request->input($column);
            if ($request->filled($column) && ! Search::notDropDown($value, $column)) {
                $query->where($column, '=', $value);
            }
        }
    }

    /**
     * "age-range" is "<youngest>-<oldest>" in years.
     *
     * @param  Builder<Volunteer>  $query
     */
    private function filterByAgeRange(Builder $query, Request $request): void
    {
        if (! $request->filled('age-range')) {
            return;
        }

        [$youngest, $oldest] = array_map('intval', explode('-', (string) $request->input('age-range')) + [1 => 0]);

        $latestBirthDate = date('Y-m-j', strtotime("-{$youngest} year"));
        $earliestBirthDate = date('Y-m-j', strtotime("-{$oldest} year"));

        $query->whereBetween('birth_date', [$earliestBirthDate, $latestBirthDate]);
    }

    /** @param Builder<Volunteer> $query */
    private function filterByPhoneNumber(Builder $query, Request $request): void
    {
        if (! $request->filled('phoneNumber')) {
            return;
        }

        $phone = $request->input('phoneNumber');
        $query->where(function (Builder $query) use ($phone) {
            $query->where('home_tel', $phone)
                ->orWhere('work_tel', $phone)
                ->orWhere('cell_tel', $phone);
        });
    }

    /** @param Builder<Volunteer> $query */
    private function filterByRelations(Builder $query, Request $request): void
    {
        foreach (['unit_id' => ['units', 'unit_id'], 'interest_id' => ['interests', 'interest_id']] as $field => [$relation, $column]) {
            $id = $request->input($field);
            if ($request->filled($field) && ! Search::notDropDown($id, $field)) {
                $query->whereHas($relation, fn (Builder $query) => $query->where($column, $id));
            }
        }

        // the volunteer must speak all the chosen languages
        foreach ((array) $request->input('languages', []) as $languageId) {
            $query->whereHas('languages', fn (Builder $query) => $query->where('language_id', $languageId));
        }
    }
}
