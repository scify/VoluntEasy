<?php namespace App\Models\Descriptions;

use Illuminate\Database\Eloquent\Model;

class HowYouLearned extends Model {

    protected $table = 'how_you_learned';

    protected $fillable = ['description', 'comments'];

}
