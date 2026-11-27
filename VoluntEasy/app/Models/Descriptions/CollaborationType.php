<?php

namespace App\Models\Descriptions;

use App\Models\Model;
use Illuminate\Database\Eloquent\Collection;

class CollaborationType extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'collaboration_types';

    protected $fillable = ['description'];

    /**
     * The types whose translated description starts with $term (case insensitive).
     *
     * @return Collection<int, self>
     */
    public static function matching(string $term): Collection
    {
        return self::all()->filter(
            fn (self $type) => mb_stripos($type->description, $term) === 0
        )->values();
    }

    public function getDescriptionAttribute()
    {
        return trans('database/db_tables.'.$this->attributes['description']);
    }
}
