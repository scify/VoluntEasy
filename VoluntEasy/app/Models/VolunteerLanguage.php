<?php namespace App\Models;


class VolunteerLanguage extends User {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'volunteer_languages';



    public function languages()
    {
        return $this->hasMany('App\Models\Descriptions\Language');
    }


    public function language_levels()
    {
        return $this->hasMany('App\Models\Descriptions\LanguageLevel');
    }


}
