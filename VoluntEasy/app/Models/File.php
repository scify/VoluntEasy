<?php namespace App\Models;

use App\Models\Model;
class File extends Model {

    protected $table = 'volunteer_files';

    protected $fillable = ['filename', 'volunteer_id'];

}
