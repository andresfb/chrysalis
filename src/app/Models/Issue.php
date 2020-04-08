<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

/**
 * Class Issue
 *
 * @package App\Models
 */
class Issue extends Model
{
    /**
     * @var array
     */
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
     * project Method.
     *
     * @return BelongsTo
     */
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * type Method.
     *
     * @return BelongsTo
     */
    public function type()
    {
        return $this->belongsTo(IssueType::class);
    }

    /**
     * status Method.
     *
     * @return BelongsTo
     */
    public function status()
    {
        return $this->belongsTo(IssueStatus::class);
    }

    /**
     * severity Method.
     *
     * @return BelongsTo
     */
    public function severity()
    {
        return $this->belongsTo(IssueSeverity::class);
    }

    /**
     * tasks Method.
     *
     * @return HasMany
     */
    public function tasks()
    {
        return $this->hasMany(Task::class);
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
