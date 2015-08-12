<?php namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Action extends Model {

    use \SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $table = 'actions';

    protected $fillable = ['description', 'comments', 'start_date', 'end_date', 'unit_id', 'email', 'name', 'phone_number'];


    public function unit() {
        return $this->belongsTo('App\Models\Unit');
    }

    public function volunteers() {
        return $this->belongsToMany('App\Models\Volunteer', 'actions_volunteers');
    }

    public function rating() {
        return $this->hasOne('App\Models\RatingVolunteerAction');
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

    public function scopeExpireInSevenDays(){
        return $this->where('end_date', '=', \Carbon::now()->addDays(7)->format('Y-m-d'));
    }

    public function scopeActive(){
        $now = date('Y-m-d');
        return $this->where('end_date', '>=', $now);
    }
}
