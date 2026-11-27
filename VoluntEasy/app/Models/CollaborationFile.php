<?php

namespace App\Models;

class CollaborationFile extends Model
{
    protected $table = 'collaborations_files';

    protected $fillable = ['filename', 'collaboration_id'];
}
