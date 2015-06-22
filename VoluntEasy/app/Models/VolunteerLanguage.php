<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class VolunteerLanguage extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'volunteer_languages';



    public function language()
    {
        return $this->belongsTo('App\Models\Descriptions\Language');
    }


    public function level()
    {
        return $this->belongsTo('App\Models\Descriptions\LanguageLevel', 'language_level_id', 'id');
    }


}
