<?php

namespace App\Models\Roles;

use App\Models\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Module extends Model
{
    protected $table = 'modules';

    protected $fillable = ['name'];

    /** @return HasMany<ModuleAction, $this> */
    public function actions(): HasMany
    {
        return $this->hasMany(ModuleAction::class);
    }
}
