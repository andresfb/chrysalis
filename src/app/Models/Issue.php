<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Iatstuti\Database\Support\CascadeSoftDeletes;
use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

/**
 * Class Issue
 *
 * @package App\Models
 */
class Issue extends Model
{
    use Cachable, SoftDeletes, CascadeSoftDeletes;

    /**
     * @var array
     */
    protected $guarded = ['number'];

    /** @var array */
    protected $casts = [
        'id'          => 'integer',
        'project_id'  => 'integer',
        'assignee_id' => 'integer',
        'type_id'     => 'integer',
        'status_id'   => 'integer',
        'severity_id' => 'integer',
        'number'      => 'integer',
    ];

    /** @var array */
    protected $dates = ['due_date', 'deleted_at'];

    /** @var array */
    protected $cascadeDeletes = ['tasks'];

    /**
     * boot Method.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function($model) {
            $model->number = Issue::where('project_id', $model->project_id)->max('number') + 1;
        });
    }


    /**
     * getNumberAttribute Method.
     *
     * @param int $value
     * @return string
     */
    public function getNumberAttribute($value)
    {
        return sprintf("%s-%s", $this->project->code, $value);
    }

    /**
     * assignee Method.
     *
     * @return BelongsTo
     */
    public function assignee()
    {
        return $this->belongsTo(User::class, 'assignee_id', 'id');
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
