<?php namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Action extends Model {

    protected $table = 'actions';

    protected $fillable = ['description', 'comments', 'start_date', 'end_date', 'unit_id', 'email'];


    public function unit()
    {
        return $this->belongsTo('App\Models\Unit');
    }

    public function volunteers()
    {
        return $this->belongsToMany('App\Models\Volunteer', 'actions_volunteers');
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
}
