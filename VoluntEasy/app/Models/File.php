<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class File extends Model {

    protected $table = 'volunteer_files';

    protected $fillable = ['filename', 'volunteer_id'];

}
