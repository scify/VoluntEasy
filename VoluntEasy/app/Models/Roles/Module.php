<?php namespace App\Models\Roles;

use Illuminate\Database\Eloquent\Model;

class Module extends Model {

    protected $table = 'modules';

    protected $fillable = ['name'];

    public function actions()
    {
        return $this->hasMany('App\Models\Roles\ModuleAction');
    }

}
