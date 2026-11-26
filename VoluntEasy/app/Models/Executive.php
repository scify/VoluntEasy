<?php namespace App\Models;

use App\Models\Model;
class Executive extends Model {

    use \Illuminate\Database\Eloquent\SoftDeletes;

    protected $table = 'executives';

    protected $fillable = ['name', 'email', 'phone', 'address'];

}
