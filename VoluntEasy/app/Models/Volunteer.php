<?php

namespace App\Models;

use App\Models\ActionTasks\SubtaskShift;
use App\Models\ActionTasks\TaskShift;
use App\Models\CTA\CTAVolunteer;
use App\Models\Descriptions\AvailabilityDay;
use App\Models\Descriptions\AvailabilityFrequencies;
use App\Models\Descriptions\AvailabilityTime;
use App\Models\Descriptions\CommunicationMethod;
use App\Models\Descriptions\DriverLicenceType;
use App\Models\Descriptions\EducationLevel;
use App\Models\Descriptions\Gender;
use App\Models\Descriptions\HowYouLearned;
use App\Models\Descriptions\HowYouLearned2;
use App\Models\Descriptions\IdentificationType;
use App\Models\Descriptions\Interest;
use App\Models\Descriptions\MaritalStatus;
use App\Models\Descriptions\VolunteeringDepartment;
use App\Models\Descriptions\VolunteerStatus;
use App\Models\Descriptions\VolunteerStatusDuration;
use App\Models\Descriptions\WorkStatus;
use App\Models\OPARating\VolunteerRating;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * Values marked "Computed" are set by the services, they are not columns.
 *
 * @property int|null $age Computed: the age in years
 * @property bool $hideStatus Computed: hide the status for this user
 * @property mixed $not_availableTo Computed
 * @property mixed $not_availableFrom Computed
 * @property mixed $not_availableId Computed
 * @property mixed $not_availableComments Computed
 * @property mixed $lang_levels Computed
 * @property mixed $availableUnits Computed
 */
class Volunteer extends User
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'volunteers';

    protected $fillable = ['name', 'last_name', 'fathers_name', 'identification_num', 'birth_date', 'children', 'address', 'city', 'country', 'post_box', 'participation_reason', 'participation_previous', 'participation_actions', 'email', 'extra_lang', 'work_description', 'additional_skills', 'live_in_curr_country', 'comments', 'gender_id', 'education_level_id', 'comm_method', 'identification_type_id', 'marital_status_id', 'driver_license_type_id', 'availability_freqs_id', 'work_status_id',
        'home_tel', 'work_tel', 'cell_tel', 'fax', 'comm_method_id', 'specialty', 'department', 'computer_usage', 'availability_time', 'interests', 'blacklisted', 'not_available', 'how_you_learned_id', 'how_you_learned2_id', 'computer_usage_comments', 'afm', 'contract_date', 'image_name'];

    // /////////////
    // Relations //
    // /////////////

    /** @return BelongsToMany<Action, $this> */
    public function actions(): BelongsToMany
    {
        return $this->belongsToMany(Action::class, 'actions_volunteers');
    }

    /** @return BelongsToMany<AvailabilityTime, $this> */
    public function availabilityTimes(): BelongsToMany
    {
        return $this->belongsToMany(AvailabilityTime::class, 'volunteer_availability_times', 'volunteer_id', 'availability_time_id');
    }

    /** @return BelongsToMany<Interest, $this> */
    public function interests(): BelongsToMany
    {
        return $this->belongsToMany(Interest::class, 'volunteer_interests', 'volunteer_id', 'interest_id')->orderBy('description', 'asc');
    }

    /** @return BelongsToMany<VolunteeringDepartment, $this> */
    public function volunteeringDepartments(): BelongsToMany
    {
        return $this->belongsToMany(VolunteeringDepartment::class, 'volunteer_volunteering_departments', 'volunteer_id', 'department_id');
    }

    /** @return HasOne<AvailabilityFrequencies, $this> */
    public function availabilityFrequencies(): HasOne
    {
        return $this->hasOne(AvailabilityFrequencies::class, 'id', 'availability_freqs_id');
    }

    /** @return HasMany<AvailabilityDay, $this> */
    public function availabilityDays(): HasMany
    {
        return $this->hasMany(AvailabilityDay::class);
    }

    /** @return HasOne<DriverLicenceType, $this> */
    public function driverLicenceType(): HasOne
    {
        return $this->hasOne(DriverLicenceType::class, 'id', 'driver_license_type_id');
    }

    /** @return HasOne<EducationLevel, $this> */
    public function educationLevel(): HasOne
    {
        return $this->hasOne(EducationLevel::class, 'id', 'education_level_id');
    }

    /** @return HasOne<IdentificationType, $this> */
    public function identificationType(): HasOne
    {
        return $this->hasOne(IdentificationType::class, 'id', 'identification_type_id');
    }

    /** @return HasOne<WorkStatus, $this> */
    public function workStatus(): HasOne
    {
        return $this->hasOne(WorkStatus::class, 'id', 'work_status_id');
    }

    /** @return HasOne<HowYouLearned, $this> */
    public function howYouLearned(): HasOne
    {
        return $this->hasOne(HowYouLearned::class, 'id', 'how_you_learned_id');
    }

    /** @return HasOne<HowYouLearned2, $this> */
    public function howYouLearned2(): HasOne
    {
        return $this->hasOne(HowYouLearned2::class, 'id', 'how_you_learned2_id');
    }

    /** @return HasMany<VolunteerLanguage, $this> */
    public function languages(): HasMany
    {
        return $this->hasMany(VolunteerLanguage::class);
    }

    /** @return HasOne<MaritalStatus, $this> */
    public function maritalStatus(): HasOne
    {
        return $this->hasOne(MaritalStatus::class, 'id', 'marital_status_id');
    }

    /** @return HasOne<Gender, $this> */
    public function gender(): HasOne
    {
        return $this->hasOne(Gender::class, 'id', 'gender_id');
    }

    /** @return HasOne<CommunicationMethod, $this> */
    public function commMethod(): HasOne
    {
        return $this->hasOne(CommunicationMethod::class, 'id', 'comm_method_id');
    }

    /** @return HasMany<VolunteerActionHistory, $this> */
    public function actionHistory(): HasMany
    {
        return $this->hasMany(VolunteerActionHistory::class)->orderBy('created_at', 'desc');
    }

    /** @return HasOne<VolunteerActionHistory, $this> */
    public function actionHistoryNewest(): HasOne
    {
        return $this->hasOne(VolunteerActionHistory::class)->orderBy('created_at', 'desc');
    }

    /** @return HasMany<VolunteerUnitHistory, $this> */
    public function unitHistory(): HasMany
    {
        return $this->hasMany(VolunteerUnitHistory::class)->orderBy('created_at', 'desc');
    }

    /** @return HasMany<VolunteerTaskShiftHistory, $this> */
    public function taskShiftHistory(): HasMany
    {
        return $this->hasMany(VolunteerTaskShiftHistory::class)->orderBy('created_at', 'desc');
    }

    /** @return HasMany<VolunteerSubtaskShiftHistory, $this> */
    public function subtaskShiftHistory(): HasMany
    {
        return $this->hasMany(VolunteerSubtaskShiftHistory::class)->orderBy('created_at', 'desc');
    }

    /** @return BelongsToMany<Unit, $this> */
    public function units(): BelongsToMany
    {
        return $this->belongsToMany(Unit::class, 'volunteer_unit_status')->whereNull('volunteer_unit_status.deleted_at');
    }

    /** @return BelongsToMany<Unit, $this> */
    public function unitsExcludes(): BelongsToMany
    {
        return $this->belongsToMany(Unit::class, 'volunteers_units_excludes');
    }

    /** @return BelongsToMany<Unit, $this> */
    public function unitsPivot(): BelongsToMany
    {
        return $this->belongsToMany(Unit::class, 'volunteer_unit_status')->withPivot('volunteer_status_id');
    }

    /** @return HasMany<VolunteerUnitStatus, $this> */
    public function unitsStatus(): HasMany
    {
        return $this->hasMany(VolunteerUnitStatus::class)->withTrashed();
    }

    /** @return HasMany<VolunteerStepStatus, $this> */
    public function steps(): HasMany
    {
        return $this->hasMany(VolunteerStepStatus::class);
    }

    /** @return HasMany<File, $this> */
    public function files(): HasMany
    {
        return $this->hasMany(File::class);
    }

    /** @return BelongsToMany<TaskShift, $this> */
    public function taskShifts(): BelongsToMany
    {
        return $this->belongsToMany(TaskShift::class, 'volunteer_task_shifts', 'volunteer_id', 'task_shift_id');
    }

    /** @return BelongsToMany<SubtaskShift, $this> */
    public function subtaskShifts(): BelongsToMany
    {
        return $this->belongsToMany(SubtaskShift::class, 'volunteer_subtask_shifts', 'volunteer_id', 'subtask_shifts_id');
    }

    /** @return HasOne<VolunteerExtras, $this> */
    public function extras(): HasOne
    {
        return $this->hasOne(VolunteerExtras::class, 'volunteer_id', 'id');
    }

    /** @return BelongsToMany<CTAVolunteer, $this> */
    public function ctaVolunteers(): BelongsToMany
    {
        return $this->belongsToMany(CTAVolunteer::class, 'cta_volunteers_platform_volunteers', 'volunteer_id', 'cta_volunteers_id');
    }

    /** @return HasMany<VolunteerRating, $this> */
    public function opaRatings(): HasMany
    {
        return $this->hasMany(VolunteerRating::class)->withTrashed();
    }

    /** @return HasMany<VolunteerStatusDuration, $this> */
    public function statusDuration(): HasMany
    {
        return $this->hasMany(VolunteerStatusDuration::class);
    }

    public function getBirthDateAttribute()
    {
        if ($this->attributes['birth_date'] != null && $this->attributes['birth_date'] != '0000-00-00') {
            return \Carbon::parse($this->attributes['birth_date'])->format('d/m/Y');
        } else {
            return null;
        }
    }

    public function getContractDateAttribute()
    {
        if ($this->attributes['contract_date'] != null) {
            return \Carbon::parse($this->attributes['contract_date'])->format('d/m/Y');
        } else {
            return null;
        }
    }

    public function getFullNameAttribute()
    {
        return $this->name.' '.$this->last_name;
    }

    // ////////////////
    // Query Scopes //
    // ////////////////

    /**
     * Get all the volunteers that are assigned to a unit.
     *
     * @return mixed
     */
    public function scopeUnit($query, $id)
    {
        return Volunteer::whereHas('units', function ($query) use ($id) {
            $query->where('id', $id);
        });
    }

    /*** Scopes for Volunteer Statuses ***/

    /**
     * Get pending volunteers.
     *
     * @return mixed
     */
    public function scopePending($query)
    {

        $query->whereHas('units', function ($query) {
            $query->where('volunteer_status_id', VolunteerStatus::pending());
        })->where('blacklisted', false)->where('not_available', false);
    }

    /**
     * Get available volunteers.
     * Either get all of them or only those that the user
     * is permitted to edit/assign
     *
     * @return void
     */
    public function scopeAvailable($query, $permitted = null)
    {

        if ($permitted == null) {
            $query->whereHas('units', function ($query) {
                $query->where('volunteer_status_id', VolunteerStatus::available());
            })->where('blacklisted', false)->where('not_available', false);
        } else {
            $query->whereIn('id', $permitted)->whereHas('units', function ($query) {
                $query->where('volunteer_status_id', VolunteerStatus::available());
            })->where('blacklisted', false)->where('not_available', false);
        }
    }

    /**
     * Get active volunteers
     *
     * @return mixed
     */
    public function scopeActive($query)
    {

        $query->whereHas('units', function ($query) {
            $query->where('volunteer_status_id', VolunteerStatus::active());
        })->has('actions')->where('blacklisted', false)->where('not_available', false)->with('actions');

    }

    /**
     * Get unassigned volunteers.
     * All the volunteers that are not assigned to any unit
     * or that have not completed the steps of their units.
     *
     * @return mixed
     */
    public function scopeUnassigned($query)
    {
        $query->whereDoesntHave('units')->where('blacklisted', false)->where('not_available', false)->orderBy('name', 'asc');
    }

    public function scopeNotAvailable($query)
    {

        $query->where('not_available', true);
    }

    /**
     * Get blacklisted volunteers
     *
     * @return mixed
     */
    public function scopeBlacklisted($query)
    {

        $query->where('blacklisted', true);
    }

    /**
     * Check if Volunteer is interested in any action
     * \     */
    public function interestedIn()
    {

        $ctaVolunteers = CTAVolunteer::where('email', $this->attributes['email'])->with('subtaskDates.date.subtask.task')->get();

        return $ctaVolunteers;
    }

    /**
     * Find the volunteers whose contract was signed a year ago
     *
     * @return mixed
     */
    public function scopeExpiredContract()
    {
        $today = \Carbon::today();

        return $this->where('contract_date', '=', $today->subYear());
    }

    /**
     * Find the volunteers whose contract expires in 6 months
     *
     * @return mixed
     */
    public function scopeToExpireContract()
    {
        $today = \Carbon::today();

        return $this->where('contract_date', '=', $today->subMonths(6));
    }
}
