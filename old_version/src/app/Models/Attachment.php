<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * Class Attachment
 *
 * @package App\Models
 */
class Attachment extends Model
{
    /** @var array */
    protected $guarded = [];

    /**
     * mimeType Method.
     *
     * @return BelongsTo
     */
    public function mimeType()
    {
        return $this->belongsTo(MimeType::class);
    }

    /**
     * attachable Method.
     *
     * @return MorphTo
     */
    public function attachable()
    {
        return $this->morphTo();
    }
}
