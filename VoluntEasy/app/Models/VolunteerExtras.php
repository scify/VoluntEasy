<?php namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class VolunteerExtras extends Model {

    protected $table = 'volunteer_extras';

    protected $fillable = ['knows_word', 'knows_excel', 'knows_powerpoint', 'has_previousVolunteerExperience', 'hasPreviousWorkExperience', 'volunteering_work_extra', 'other_department'];

}
