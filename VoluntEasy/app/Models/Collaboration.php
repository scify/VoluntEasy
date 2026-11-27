<?php

namespace App\Models;

use App\Models\Descriptions\CollaborationType;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Values marked "Computed" are set by the services, they are not columns.
 *
 * @property bool $expired Computed
 */
class Collaboration extends Model
{
    use SoftDeletes;

    protected $table = 'collaborations';

    protected $fillable = ['name', 'comments', 'type_id', 'start_date', 'end_date', 'phone', 'address'];

    /** @return HasMany<CollaborationFile, $this> */
    public function files(): HasMany
    {
        return $this->hasMany(CollaborationFile::class, 'collaboration_id', 'id');
    }

    /** @return BelongsToMany<Executive, $this> */
    public function executives(): BelongsToMany
    {
        return $this->belongsToMany(Executive::class, 'collaborations_executives', 'collaboration_id', 'executive_id');
    }

    /**
     * Format dates before showing on front end
     *
     * @return string
     */
    public function getStartDateAttribute()
    {
        return \Carbon::parse($this->attributes['start_date'])->format('d/m/Y');
    }

    public function getEndDateAttribute()
    {
        return \Carbon::parse($this->attributes['end_date'])->format('d/m/Y');
    }

    /** @return HasOne<CollaborationType, $this> */
    public function type(): HasOne
    {
        return $this->hasOne(CollaborationType::class, 'id', 'type_id');
    }
}
