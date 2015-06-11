<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    protected $table = 'units';

    protected $fillable = ['description', 'comments', 'level', 'user_id', 'parent_id', 'start_date', 'end_date'];


    public function users()
    {
        return $this->belongsToMany('App\Models\User', 'units_to_users', 'unit_id', 'user_id');
    }

    public function scopeParent($query, $parent_id){
        return $query->whereId($parent_id);
    }

}
