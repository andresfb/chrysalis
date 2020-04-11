<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Comment
 *
 * @package App\Models
 */
class Comment extends Model
{
    use SoftDeletes;

    /** @var array */
    protected $guarded = [];

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
     * commentable Method.
     *
     * @return MorphTo
     */
    public function commentable()
    {
        return $this->morphTo();
    }
}
