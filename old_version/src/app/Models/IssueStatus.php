<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class IssueStatuses
 *
 * @package App\Models
 */
class IssueStatus extends Model
{
    /** @var array */
    protected $guarded = [];

    /** @var bool */
    public $timestamps = false;

    /**
     * issues Method.
     *
     * @return HasMany
     */
    public function issues()
    {
        return $this->hasMany(Issue::class);
    }
}
