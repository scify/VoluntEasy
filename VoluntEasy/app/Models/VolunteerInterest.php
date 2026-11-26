<?php namespace App\Models;

use App\Models\Model;
class VolunteerInterest extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'volunteer_interests';

    protected $fillable = ['volunteer_id', 'interest_id'];
}
