<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class TaskStatus
 *
 * @package App\Models
 */
class TaskStatus extends Model
{
    /** @var array */
    protected $guarded = [];

    /** @var bool */
    public $timestamps = false;

    /**
     * tasks Method.
     *
     * @return HasMany
     */
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
}
