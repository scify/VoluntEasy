<?php namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Carbon\Carbon;
use App\Models\Model;
/**
 * Values marked "Computed" are set by the services, they are not columns.
 *
 * @property bool $expired Computed
 * @property float|int $workHours Computed
 * @property int $volunteer_count Computed
 * @property int $ratingMinutes Computed
 * @property int $ratingHours Computed
 * @property int $ratingCount Computed
 * @property string|null $ratingComments Computed
 */
class Action extends Model {

    use \Illuminate\Database\Eloquent\SoftDeletes;

    protected $table = 'actions';

    protected $fillable = ['description', 'comments', 'start_date', 'end_date', 'unit_id', 'email', 'name', 'phone_number', 'volunteer_sum'];

    /** @return BelongsTo<\App\Models\Unit, $this> */
    public function unit(): BelongsTo {
        return $this->belongsTo(\App\Models\Unit::class);
    }

    /** @return BelongsToMany<\App\Models\User, $this> */
    public function users(): BelongsToMany {
        return $this->belongsToMany(\App\Models\User::class, 'actions_users');
    }

    /** @return BelongsToMany<\App\Models\Volunteer, $this> */
    public function volunteers(): BelongsToMany {
        return $this->belongsToMany(\App\Models\Volunteer::class, 'actions_volunteers');
    }

    //volunteer ratings
    /** @return HasMany<\App\Models\Rating\ActionRating, $this> */
    public function ratings(): HasMany {
        return $this->hasMany(\App\Models\Rating\ActionRating::class, 'action_id', 'id');
    }

    //action ratings
    /** @return HasMany<\App\Models\Rating\ActionScore, $this> */
    public function actionRatings(): HasMany {
        return $this->hasMany(\App\Models\Rating\ActionScore::class, 'action_id', 'id');
    }

    /** @return HasMany<\App\Models\ActionTasks\Task, $this> */
    public function tasks(): HasMany {
        return $this->hasMany(\App\Models\ActionTasks\Task::class, 'action_id', 'id');
    }

    /** @return HasMany<\App\Models\ActionTasks\Task, $this> */
    public function allTasks(): HasMany {
        return $this->hasMany(\App\Models\ActionTasks\Task::class, 'action_id', 'id')->withTrashed();
    }

    //public action
    /** @return HasOne<\App\Models\CTA\PublicAction, $this> */
    public function publicAction(): HasOne {
        return $this->hasOne(\App\Models\CTA\PublicAction::class, 'action_id', 'id');
    }

    /**
     * Format dates before showing on front end
     *
     * @return string
     */
    public function getStartDateAttribute() {
        return Carbon::parse($this->attributes['start_date'])->format('d/m/Y');
    }

    public function getEndDateAttribute() {
        return Carbon::parse($this->attributes['end_date'])->format('d/m/Y');
    }

    public function scopeExpireToday(){
        $now = date('Y-m-d');
        return $this->where('end_date', '=', $now);
    }

    public function scopeExpiredYesterday(){
        $yesterday = Carbon::yesterday();
        return $this->where('end_date', '=', $yesterday);
    }

    public function scopeExpireInSevenDays(){
        return $this->where('end_date', '=', \Carbon::now()->addDays(7)->format('Y-m-d'));
    }

    public function scopeActive(){
        $now = date('Y-m-d');
        return $this->where('end_date', '>=', $now);
    }

    public function scopeInactive(){
        $now = date('Y-m-d');
        return $this->where('end_date', '<', $now);
    }
}
