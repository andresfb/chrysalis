<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

/**
 * Class Project
 *
 * @package App\Models
 */
class Project extends Model
{
    use SoftDeletes;

    /** @var array */
    protected $guarded = ['code'];

    /** @var array */
    protected $hidden = ['code'];

    /**
     * booted Method.
     *
     * @return void
     */
    protected static function booted()
    {
        static::creating(function ($project) {
            if (empty($project->code)) {
                $project->code = "NEW";
            }
        });

        static::created(function ($project) {
            if ($project->code != 'NEW') {
                return;
            }

            $parts = [];
            $title = trim($project->title);
            if (!Str::contains($title, " ")) {
                $parts[] = $title[0];
                $parts[] = $title[1];
            } else {
                $parts = explode(" ", $title);
            }

            $project->code = strtoupper($parts[0] . $parts[1]) . "-" . $project->id;
            $project->save();
        });
    }

    /**
     * owner Method.
     *
     * @return BelongsTo
     */
    public function owner()
    {
        return $this->belongsTo(User::class, 'id', 'owner_id');
    }

    /**
     * category Method.
     *
     * @return BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * status Method.
     *
     * @return BelongsTo
     */
    public function status()
    {
        return $this->belongsTo(ProjectStatus::class);
    }

    /**
     * issues Method.
     *
     * @return HasMany
     */
    public function issues()
    {
        return $this->hasMany(Issue::class);
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
