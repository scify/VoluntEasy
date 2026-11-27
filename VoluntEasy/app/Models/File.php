<?php

namespace App\Models;

class File extends Model
{
    protected $table = 'volunteer_files';

    protected $fillable = ['filename', 'volunteer_id'];
}
