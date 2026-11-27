<?php

namespace App\Models\Descriptions;

use App\Models\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class InterestCategory extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'interest_categories';

    protected $fillable = ['description'];

    public function getDescriptionAttribute()
    {
        return trans('database/db_tables.'.$this->attributes['description']);
    }

    /** @return HasMany<Interest, $this> */
    public function interests(): HasMany
    {
        return $this->hasMany(Interest::class, 'category_id', 'id')->orderBy('description', 'asc');
    }
}
