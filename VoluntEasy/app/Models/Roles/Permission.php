<?php namespace App\Models\Roles;

use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Models\Model;
class Permission extends Model {

    protected $table = 'roles_permissions';

    protected $fillable = ['role_id', 'module_id', 'action_id'];

    /** @return HasOne<\App\Models\Roles\Module, $this> */
    public function module(): HasOne {
        return $this->hasOne(\App\Models\Roles\Module::class, 'id', 'module_id');
    }

    /** @return HasOne<\App\Models\Roles\ModuleAction, $this> */
    public function action(): HasOne {
        return $this->hasOne(\App\Models\Roles\ModuleAction::class, 'id', 'action_id');
    }
}
