<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class MimeType
 *
 * @package App\Models
 */
class MimeType extends Model
{
    /** @var array */
    protected $guarded = [];

    /** @var array */
    public $timestamps = [];

    /**
     * attachments Method.
     *
     * @return HasMany
     */
    public function attachments()
    {
        return $this->hasMany(Attachment::class);
    }
}
