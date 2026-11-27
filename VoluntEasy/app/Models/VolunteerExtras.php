<?php

namespace App\Models;

class VolunteerExtras extends Model
{
    protected $table = 'volunteer_extras';

    protected $fillable = ['knows_word', 'knows_excel', 'knows_powerpoint', 'has_previous_volunteer_experience', 'has_previous_work_experience', 'volunteering_work_extra', 'other_department'];
}
