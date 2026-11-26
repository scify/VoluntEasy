<?php namespace App\Models;


use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Concerns\SerializesDatesAsMysql;
use App\Models\Traits\Permissible;
use App\Notifications\ResetPasswordNotification;
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


    /** @return BelongsToMany<\App\Models\Unit, $this> */
    public function units(): BelongsToMany {
        return $this->belongsToMany(\App\Models\Unit::class, 'units_users', 'user_id', 'unit_id');
    }

    /** @return BelongsToMany<\App\Models\Action, $this> */
    public function actions(): BelongsToMany {
        return $this->belongsToMany(\App\Models\Action::class, 'actions_users', 'user_id', 'action_id');
    }

    public function setPasswordAttribute($password)
    {
	   return $this->attributes['password'] = $password;
    }

    /**
     * The in-app notifications of the user (the "bell" in the top bar).
     * @return HasMany<\App\Models\Notification, $this>
     */
    public function notifications(): HasMany {
        return $this->hasMany(\App\Models\Notification::class)->orderBy('updated_at', 'desc');
    }

    public function sendPasswordResetNotification($token): void
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    /** @return BelongsToMany<\App\Models\Roles\Role, $this> */
    public function roles(): BelongsToMany {
        return $this->belongsToMany(\App\Models\Roles\Role::class, 'users_roles', 'user_id', 'role_id')->orderBy('id', 'asc');
    }

    public function getFullNameAttribute()
    {
        return $this->name . " " . $this->last_name;
    }

    /**
     * Check if user has a certain unit.
     *
     * @param $query
     * @param $id
     * @return mixed
     */
    public function scopeUnit($query, $id)
    {
        return User::whereHas('units', function ($query) use ($id) {
            $query->where('id', $id);
        });
    }
}
