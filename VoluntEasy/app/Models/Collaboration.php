<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Collaboration extends Model {

    use \SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $table = 'collaborations';

    protected $fillable = ['name', 'comments', 'type', 'start_date', 'end_date', 'phone', 'address'];


    public function files() {
        return $this->hasMany('App\Models\CollaborationFile', 'collaboration_id', 'id');
    }

    public function executives() {
        return $this->belongsToMany('App\Models\Executive', 'collaborations_executives', 'collaboration_id', 'executive_id');
    }

    /**
     * Format dates before showing on front end
     *
     * @return string
     */
    public function getStartDateAttribute() {
        return \Carbon::parse($this->attributes['start_date'])->format('d/m/Y');
    }

    public function getEndDateAttribute() {
        return \Carbon::parse($this->attributes['end_date'])->format('d/m/Y');
    }

}
