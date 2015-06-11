<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Steps extends Model {

    protected $table = 'steps';

    protected $fillable = ['description', 'step_order'];

}
