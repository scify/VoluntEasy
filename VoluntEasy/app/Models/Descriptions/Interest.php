<?php namespace App\Models\Descriptions;

use Illuminate\Database\Eloquent\Model;


class Interest extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'interests';

    protected $fillable = ['description', 'category'];


}