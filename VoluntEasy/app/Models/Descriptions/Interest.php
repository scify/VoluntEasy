<?php namespace App\Models\Descriptions;


use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Models\Model;
/**
 * Values marked "Computed" are set by the services, they are not columns.
 *
 * @property int $count Computed: number of volunteers (reports)
 */
class Interest extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'interests';

    protected $fillable = ['description', 'category_id'];


    public function getDescriptionAttribute() {
        return trans('database/db_tables.' . $this->attributes['description']);
    }

    /** @return HasOne<\App\Models\Descriptions\InterestCategory, $this> */
    public function category(): HasOne {
        return $this->hasOne(\App\Models\Descriptions\InterestCategory::class, 'id', 'category_id');
    }
}
