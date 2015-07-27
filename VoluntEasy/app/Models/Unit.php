<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Unit extends Model {

    use \SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $table = 'units';

    protected $fillable = ['description', 'comments', 'level',
        'user_id', 'parent_unit_id', 'start_date', 'end_date'];

    /**
     * Retrieve the users associated with the unit
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users() {
        return $this->belongsToMany('App\Models\User', 'units_users', 'unit_id', 'user_id');
    }

    public function actions() {
        return $this->hasMany('App\Models\Action');
    }

    public function steps() {
        return $this->hasMany('App\Models\Step')->orderBy('step_order', 'asc');
    }

    public function volunteers() {
        return $this->belongsToMany('App\Models\Volunteer', 'volunteer_unit_status')->orderBy('name', 'asc');
    }

    /**
     * Get the unit's parent unit
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function parent() {
        return $this->hasOne('App\Models\Unit', 'id', 'parent_unit_id');
    }

    /**
     * Get the unit's children/branches
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function children() {
        return $this->hasMany('App\Models\Unit', 'parent_unit_id', 'id');
    }

    /**
     * Get all children/branches of a node (with Actions)
     *
     * @return mixed
     */
    public function allChildren() {
        return $this->children()->with('allChildren', 'actions');
    }

    /**
     * Get all parents of a node
     *
     * @return mixed
     */
    public function allParents() {
        return $this->parent()->with('allParents');
    }

}
