<?php namespace App\Models;


use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Models\Model;
/**
 * Values marked "Computed" are set by the services, they are not columns.
 *
 * @property mixed $branch Computed
 * @property mixed $availableUnits Computed
 */
class Unit extends Model {

    use \Illuminate\Database\Eloquent\SoftDeletes;

    protected $table = 'units';

    protected $fillable = ['description', 'comments', 'level', 'user_id', 'parent_unit_id', 'start_date', 'end_date'];

    /**
     * Retrieve the users associated with the unit
     *
     * @return BelongsToMany<\App\Models\User, $this>
     */
    public function users(): BelongsToMany {
        return $this->belongsToMany(\App\Models\User::class, 'units_users', 'unit_id', 'user_id');
    }

    /**
     * Show only the active actions (their end date is after current time)
     *
     * @return HasMany<\App\Models\Action, $this>
     */
    public function actions(): HasMany {
        $now = date('Y-m-d');
        return $this->hasMany(\App\Models\Action::class)->where('end_date', '>=', $now);
    }

    /**
     * Get all actions, active and past
     * @return HasMany<\App\Models\Action, $this>
     */
    public function allActions(): HasMany {
        return $this->hasMany(\App\Models\Action::class)->orderBy('end_date', 'asc');
    }


    /** @return HasMany<\App\Models\Step, $this> */
    public function steps(): HasMany {
        return $this->hasMany(\App\Models\Step::class)->orderBy('step_order', 'asc');
    }

    /** @return BelongsToMany<\App\Models\Volunteer, $this> */
    public function volunteers(): BelongsToMany {
        return $this->belongsToMany(\App\Models\Volunteer::class, 'volunteer_unit_status')->orderBy('name', 'asc');
    }

    /**
     * Get the unit's parent unit
     *
     * @return HasOne<\App\Models\Unit, $this>
     */
    public function parent(): HasOne {
        return $this->hasOne(\App\Models\Unit::class, 'id', 'parent_unit_id');
    }

    /**
     * Get the unit's children/branches
     *
     * @return HasMany<\App\Models\Unit, $this>
     */
    public function children(): HasMany {
        return $this->hasMany(\App\Models\Unit::class, 'parent_unit_id', 'id');
    }

    /**
     * Get all children/branches of a node (with Actions)
     *
     * @return HasMany<\App\Models\Unit, $this>
     */
    public function allChildren(): HasMany {
        return $this->children()->with('allChildren', 'actions', 'allActions');
    }

    /**
     * Get all parents of a node
     *
     * @return HasOne<\App\Models\Unit, $this>
     */
    public function allParents(): HasOne {
        return $this->parent()->with('allParents');
    }

}
