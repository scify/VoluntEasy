<?php

namespace App\Models\Roles;

use App\Models\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Permission extends Model
{
    protected $table = 'roles_permissions';

    protected $fillable = ['role_id', 'module_id', 'action_id'];

    /** @return HasOne<Module, $this> */
    public function module(): HasOne
    {
        return $this->hasOne(Module::class, 'id', 'module_id');
    }

    /** @return HasOne<ModuleAction, $this> */
    public function action(): HasOne
    {
        return $this->hasOne(ModuleAction::class, 'id', 'action_id');
    }
}
