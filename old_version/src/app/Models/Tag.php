<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

/**
 * Class Tag
 *
 * @package App\Models
 */
class Tag extends Model
{
    /** @var array */
    protected $guarded = [];

    /**
     * projects Method.
     *
     * @return MorphToMany
     */
    public function projects()
    {
        return $this->morphedByMany(Project::class, 'taggable');
    }

    /**
     * issues Method.
     *
     * @return MorphToMany
     */
    public function issues()
    {
        return $this->morphedByMany(Issue::class, 'taggable');
    }

    /**
     * tasks Method.
     *
     * @return MorphToMany
     */
    public function tasks()
    {
        return $this->morphedByMany(Task::class, 'taggable');
    }
}
