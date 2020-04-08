<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

/**
 * Class Task
 *
 * @package App\Models
 */
class Task extends Model
{
    /** @var array */
    protected $guarded = [];

    /**
     * assignee Method.
     *
     * @return BelongsTo
     */
    public function assignee()
    {
        return $this->belongsTo(User::class, 'id', 'assignee_id');
    }

    /**
     * issue Method.
     *
     * @return BelongsTo
     */
    public function issue()
    {
        return $this->belongsTo(Issue::class);
    }

    /**
     * status Method.
     *
     * @return BelongsTo
     */
    public function status()
    {
        return $this->belongsTo(TaskStatus::class);
    }

    /**
     * priority Method.
     *
     * @return BelongsTo
     */
    public function priority()
    {
        return $this->belongsTo(TaskPriority::class);
    }

    /**
     * tags Method.
     *
     * @return MorphToMany
     */
    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }
}
