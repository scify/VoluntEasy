<?php namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    protected $table = 'units';

    protected $fillable = ['description', 'comments', 'level', 'user_id', 'parent_unit_id', 'start_date', 'end_date'];

    /**
     * Retrieve the users associated with the unit
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany('App\Models\User', 'units_to_users', 'unit_id', 'user_id');
    }

    /**
     * Get the unit's parent unit
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function parent(){
        //dd($this->getKey('parent_unit_id'));
        //if($this->attributes('parent_unit_id')!=$this->attributes('id'))
         return $this->hasOne('App\Models\Unit', 'id', 'parent_unit_id');
    }

    /**
     * Get the unit's children/branches
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function children(){
        return $this->hasMany('App\Models\Unit', 'parent_unit_id', 'id')->whereRaw('parent_unit_id<>id');
    }

    /**
     * Get all children/branches of a node
     *
     * @return mixed
     */
    public function allChildren()
    {
        return $this->children()->with('allChildren');
    }


    /**
     * Format dates before showing on front end
     *
     * @return string
     */
    public function getStartDateAttribute(){
        return Carbon::parse($this->attributes['start_date'])->format('d/m/Y');
    }

    public function getEndDateAttribute(){
        return Carbon::parse($this->attributes['end_date'])->format('d/m/Y');
    }


     /*
    public function setStartDateAttribute($date){
        dd(Carbon::parse($date)->format('dd/mm/yyyy'));

        $this->attributes['start_date'] = Carbon::parse($date)->format('d/m/Y');
    }

    public function setEndDateAttribute($date){
        dd(Carbon::parse($date));
        $this->attributes['end_date'] = Carbon::parse($date)->format('d/m/Y');
     // createFromFormat('d/m/Y', $date);
    }*/

}