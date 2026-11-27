<?php

namespace App\Models\Roles;

use App\Models\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ModuleAction extends Model
{
    protected $table = 'module_actions';

    protected $fillable = ['name'];

    /** @return BelongsTo<Module, $this> */
    public function module(): BelongsTo
    {
        return $this->belongsTo(Module::class);
    }
}
