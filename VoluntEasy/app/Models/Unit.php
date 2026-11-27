<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Values marked "Computed" are set by the services, they are not columns.
 *
 * @property mixed $branch Computed
 * @property mixed $availableUnits Computed
 */
class Unit extends Model
{
    use SoftDeletes;

    protected $table = 'units';

    protected $fillable = ['description', 'comments', 'level', 'user_id', 'parent_unit_id', 'start_date', 'end_date'];

    /**
     * Retrieve the users associated with the unit
     *
     * @return BelongsToMany<User, $this>
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'units_users', 'unit_id', 'user_id');
    }

    /**
     * Show only the active actions (their end date is after current time)
     *
     * @return HasMany<Action, $this>
     */
    public function actions(): HasMany
    {
        $now = date('Y-m-d');

        return $this->hasMany(Action::class)->where('end_date', '>=', $now);
    }

    /**
     * Get all actions, active and past
     *
     * @return HasMany<Action, $this>
     */
    public function allActions(): HasMany
    {
        return $this->hasMany(Action::class)->orderBy('end_date', 'asc');
    }

    /** @return HasMany<Step, $this> */
    public function steps(): HasMany
    {
        return $this->hasMany(Step::class)->orderBy('step_order', 'asc');
    }

    /** @return BelongsToMany<Volunteer, $this> */
    public function volunteers(): BelongsToMany
    {
        return $this->belongsToMany(Volunteer::class, 'volunteer_unit_status')->orderBy('name', 'asc');
    }

    /**
     * Get the unit's parent unit
     *
     * @return HasOne<Unit, $this>
     */
    public function parent(): HasOne
    {
        return $this->hasOne(Unit::class, 'id', 'parent_unit_id');
    }

    /**
     * Get the unit's children/branches
     *
     * @return HasMany<Unit, $this>
     */
    public function children(): HasMany
    {
        return $this->hasMany(Unit::class, 'parent_unit_id', 'id');
    }

    /**
     * Get all children/branches of a node (with Actions)
     *
     * @return HasMany<Unit, $this>
     */
    public function allChildren(): HasMany
    {
        return $this->children()->with('allChildren', 'actions', 'allActions');
    }

    /**
     * Get all parents of a node
     *
     * @return HasOne<Unit, $this>
     */
    public function allParents(): HasOne
    {
        return $this->parent()->with('allParents');
    }
}
