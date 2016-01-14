<?php namespace App\Models\Roles;

use Illuminate\Database\Eloquent\Model;

class ModuleAction extends Model {

    protected $table = 'module_actions';

    protected $fillable = ['name'];

    public function module()
    {
        return $this->belongsTo('App\Models\Roles\Module');
    }

}
