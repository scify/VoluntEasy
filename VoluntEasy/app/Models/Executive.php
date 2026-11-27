<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Executive extends Model
{
    use SoftDeletes;

    protected $table = 'executives';

    protected $fillable = ['name', 'email', 'phone', 'address'];
}
