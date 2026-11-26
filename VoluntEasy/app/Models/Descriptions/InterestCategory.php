<?php namespace App\Models\Descriptions;


use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Model;
class InterestCategory extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'interest_categories';

    protected $fillable = ['description'];


    public function getDescriptionAttribute() {
        return trans('database/db_tables.' . $this->attributes['description']);
    }

    /** @return HasMany<\App\Models\Descriptions\Interest, $this> */
    public function interests(): HasMany {
        return $this->hasMany(\App\Models\Descriptions\Interest::class, 'category_id', 'id')->orderBy('description', 'asc');
    }

}
