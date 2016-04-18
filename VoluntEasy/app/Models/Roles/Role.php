<?php namespace App\Models\Roles;

use Illuminate\Database\Eloquent\Model;

class Role extends Model {

    protected $table = 'roles';

    protected $fillable = ['name'];

    public function permissions() {
        return $this->hasMany('App\Models\Roles\Permission');
    }

    public function users() {
        return $this->belongsToMany('App\Models\User');
    }

}
