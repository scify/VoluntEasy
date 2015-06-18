<?php namespace App\Models;


class Volunteer extends User
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'volunteers';

    protected $fillable = ['name', 'fathers_name', 'last_name', 'identification_num', 'birth_date', 'gender', 'participation_reason', 'extra_lang', 'comments', 'identification_type_id', 'marital_status_id', 'driver_license_type_id', 'availability_freqs_id', 'work_status_id'];


    public function actions()
    {
        return $this->belongsToMany('App\Models\Action');
    }

    public function actionStatus()
    {
        return $this->hasMany('App\Models\VolunteerActionStatus');
    }

    public function languages()
    {
        return $this->hasMany('App\Models\VolunteerLanguage');
    }


    public function actionHistories()
    {
        return $this->hasMany('App\Models\VolunteerActionHistory');
    }

    public function stepHistories()
    {
        return $this->hasMany('App\Models\VolunteerStepHistory');
    }
}
