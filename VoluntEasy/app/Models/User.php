<?php

namespace App\Models;

use App\Models\Concerns\SerializesDatesAsMysql;
use App\Models\Roles\Role;
use App\Models\Traits\Permissible;
use App\Notifications\ResetPasswordNotification;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\RoutesNotifications;

class User extends Authenticatable
{
    use Permissible, RoutesNotifications, SerializesDatesAsMysql, SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = ['name', 'last_name', 'email', 'password', 'addr', 'tel', 'image_name'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var list<string>
     */
    protected $hidden = ['password', 'remember_token'];

    /** @return BelongsToMany<Unit, $this> */
    public function units(): BelongsToMany
    {
        return $this->belongsToMany(Unit::class, 'units_users', 'user_id', 'unit_id');
    }

    /** @return BelongsToMany<Action, $this> */
    public function actions(): BelongsToMany
    {
        return $this->belongsToMany(Action::class, 'actions_users', 'user_id', 'action_id');
    }

    public function setPasswordAttribute($password)
    {
        return $this->attributes['password'] = $password;
    }

    /**
     * The in-app notifications of the user (the "bell" in the top bar).
     *
     * @return HasMany<Notification, $this>
     */
    public function notifications(): HasMany
    {
        return $this->hasMany(Notification::class)->orderBy('updated_at', 'desc');
    }

    public function sendPasswordResetNotification($token): void
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    /** @return BelongsToMany<Role, $this> */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'users_roles', 'user_id', 'role_id')->orderBy('id', 'asc');
    }

    public function getFullNameAttribute()
    {
        return $this->name.' '.$this->last_name;
    }

    /**
     * Check if user has a certain unit.
     *
     * @return mixed
     */
    public function scopeUnit($query, $id)
    {
        return User::whereHas('units', function ($query) use ($id) {
            $query->where('id', $id);
        });
    }
}
