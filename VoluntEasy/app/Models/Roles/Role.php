<?php namespace App\Models\Roles;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Model;
class Role extends Model {

    protected $table = 'roles';

    protected $fillable = ['name'];

    /** @return HasMany<\App\Models\Roles\Permission, $this> */
    public function permissions(): HasMany {
        return $this->hasMany(\App\Models\Roles\Permission::class);
    }

    /** @return BelongsToMany<\App\Models\User, $this> */
    public function users(): BelongsToMany {
        return $this->belongsToMany(\App\Models\User::class);
    }

}
