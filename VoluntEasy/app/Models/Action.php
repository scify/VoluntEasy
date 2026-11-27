<?php

namespace App\Models;

use App\Models\ActionTasks\Task;
use App\Models\CTA\PublicAction;
use App\Models\Rating\ActionRating;
use App\Models\Rating\ActionScore;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Values marked "Computed" are set by the services, they are not columns.
 *
 * @property bool $expired Computed
 * @property float|int $workHours Computed
 * @property int $volunteer_count Computed
 * @property int $ratingMinutes Computed
 * @property int $ratingHours Computed
 * @property int $ratingCount Computed
 * @property int $volunteerTaskSum Computed: volunteers needed by all shifts
 * @property string|null $ratingComments Computed
 */
class Action extends Model
{
    use SoftDeletes;

    protected $table = 'actions';

    protected $fillable = ['description', 'comments', 'start_date', 'end_date', 'unit_id', 'email', 'name', 'phone_number', 'volunteer_sum'];

    /** @return BelongsTo<Unit, $this> */
    public function unit(): BelongsTo
    {
        return $this->belongsTo(Unit::class);
    }

    /** @return BelongsToMany<User, $this> */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'actions_users');
    }

    /** @return BelongsToMany<Volunteer, $this> */
    public function volunteers(): BelongsToMany
    {
        return $this->belongsToMany(Volunteer::class, 'actions_volunteers');
    }

    // volunteer ratings
    /** @return HasMany<ActionRating, $this> */
    public function ratings(): HasMany
    {
        return $this->hasMany(ActionRating::class, 'action_id', 'id');
    }

    // action ratings
    /** @return HasMany<ActionScore, $this> */
    public function actionRatings(): HasMany
    {
        return $this->hasMany(ActionScore::class, 'action_id', 'id');
    }

    /** @return HasMany<Task, $this> */
    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class, 'action_id', 'id');
    }

    /** @return HasMany<Task, $this> */
    public function allTasks(): HasMany
    {
        return $this->hasMany(Task::class, 'action_id', 'id')->withTrashed();
    }

    // public action
    /** @return HasOne<PublicAction, $this> */
    public function publicAction(): HasOne
    {
        return $this->hasOne(PublicAction::class, 'action_id', 'id');
    }

    /**
     * Format dates before showing on front end
     *
     * @return string
     */
    public function getStartDateAttribute()
    {
        return Carbon::parse($this->attributes['start_date'])->format('d/m/Y');
    }

    public function getEndDateAttribute()
    {
        return Carbon::parse($this->attributes['end_date'])->format('d/m/Y');
    }

    public function scopeExpireToday()
    {
        $now = date('Y-m-d');

        return $this->where('end_date', '=', $now);
    }

    public function scopeExpiredYesterday()
    {
        $yesterday = Carbon::yesterday();

        return $this->where('end_date', '=', $yesterday);
    }

    public function scopeExpireInSevenDays()
    {
        return $this->where('end_date', '=', \Carbon::now()->addDays(7)->format('Y-m-d'));
    }

    public function scopeActive()
    {
        $now = date('Y-m-d');

        return $this->where('end_date', '>=', $now);
    }

    public function scopeInactive()
    {
        $now = date('Y-m-d');

        return $this->where('end_date', '<', $now);
    }
}
