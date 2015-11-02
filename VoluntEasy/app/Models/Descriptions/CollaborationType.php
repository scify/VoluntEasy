<?php namespace App\Models\Descriptions;

use Illuminate\Database\Eloquent\Model;


class CollaborationType extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'collaboration_types';

    protected $fillable = ['description'];
}
