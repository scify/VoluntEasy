<?php namespace App\Models\Descriptions;

use Illuminate\Database\Eloquent\Model;

class VolunteerStatus extends Model {

    protected $table = 'volunteer_statuses';

    protected $fillable = ['description'];


    public function scopePending() {
        $pendingStatus = VolunteerStatus::where('description', 'Pending')->first();

        return $pendingStatus->id;
    }

    public function scopeAvailable() {
        $pendingStatus = VolunteerStatus::where('description', 'Available')->first();

        return $pendingStatus->id;
    }

    public function scopeActive() {
        $pendingStatus = VolunteerStatus::where('description', 'Active')->first();

        return $pendingStatus->id;
    }

    public function scopeBlacklisted() {
        $pendingStatus = VolunteerStatus::where('description', 'Blacklisted')->first();

        return $pendingStatus->id;
    }

}
