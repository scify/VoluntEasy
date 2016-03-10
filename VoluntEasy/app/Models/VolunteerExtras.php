<?php namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class VolunteerExtras extends Model {

    protected $table = 'volunteer_extras';

    protected $fillable = ['knows_word', 'knows_excel', 'knows_powerpoint', 'has_previous_volunteer_experience', 'has_previous_work_experience', 'volunteering_work_extra', 'other_department', 'how_you_learned_id2'];


    public function howYouLearned2() {
        return $this->hasOne('App\Models\Descriptions\HowYouLearned2', 'id', 'how_you_learned_id2');
    }
}
