<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CollaborationFile extends Model {

    protected $table = 'collaborations_files';

    protected $fillable = ['filename', 'collaboration_id'];

}
