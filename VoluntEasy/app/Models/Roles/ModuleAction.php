<?php namespace App\Models\Roles;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Model;
class ModuleAction extends Model {

    protected $table = 'module_actions';

    protected $fillable = ['name'];

    /** @return BelongsTo<\App\Models\Roles\Module, $this> */
    public function module(): BelongsTo {
        return $this->belongsTo(\App\Models\Roles\Module::class);
    }

}
