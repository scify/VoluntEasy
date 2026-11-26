<?php namespace App\Models;

use App\Models\Model;
class CollaborationFile extends Model {

    protected $table = 'collaborations_files';

    protected $fillable = ['filename', 'collaboration_id'];

}
