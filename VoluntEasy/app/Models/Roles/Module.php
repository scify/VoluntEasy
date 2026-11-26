<?php namespace App\Models\Roles;

use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Model;
class Module extends Model {

    protected $table = 'modules';

    protected $fillable = ['name'];

    /** @return HasMany<\App\Models\Roles\ModuleAction, $this> */
    public function actions(): HasMany {
        return $this->hasMany(\App\Models\Roles\ModuleAction::class);
    }

}
