<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class ProjectStatus
 *
 * @package App\Models
 */
class ProjectStatus extends Model
{
    /** @var array */
    protected $guarded = [];

    /**
     * projects Method.
     *
     * @return HasMany
     */
    public function projects()
    {
        return $this->hasMany(Project::class);
    }
}
