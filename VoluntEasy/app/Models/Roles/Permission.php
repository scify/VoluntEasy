<?php namespace App\Models\Roles;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model {

    protected $table = 'roles_permissions';

    protected $fillable = ['role_id', 'module_id', 'action_id'];


    public function module() {
        return $this->hasOne('App\Models\Roles\Module', 'id', 'module_id');
    }

    public function action() {
        return $this->hasOne('App\Models\Roles\ModuleAction', 'id', 'action_id');
    }
}
