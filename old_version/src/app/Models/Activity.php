<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Activity
 *
 * @package App\Models
 */
class Activity extends Model
{
    use SoftDeletes;

    /** @var array */
    protected $guarded = [];

    /**
     * type Method.
     *
     * @return BelongsTo
     */
    public function type()
    {
        return $this->belongsTo(ActivityType::class);
    }

    /**
     * user Method.
     *
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * activitable Method.
     *
     * @return MorphTo
     */
    public function activitable()
    {
        return $this->morphTo();
    }
}
