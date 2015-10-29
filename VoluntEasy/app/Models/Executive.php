<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Executive extends Model {

    use \SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $table = 'executives';

    protected $fillable = ['name', 'email', 'phone', 'address'];

}
