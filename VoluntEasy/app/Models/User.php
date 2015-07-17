<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\Model;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract
{

    use Authenticatable, CanResetPassword;
    
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'password', 'addr', 'tel'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];


    public function units()
    {
        return $this->belongsToMany('App\Models\Unit', 'units_users', 'user_id', 'unit_id');
    }

    public function setPasswordAttribute($password)
    {
	   return $this->attributes['password'] = $password;
    }

    public function notifications()
    {
        return $this->hasMany('App\Models\Notification')->orderBy('updated_at', 'desc');
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
