<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Iatstuti\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

/**
 * Class Project
 *
 * @package App\Models
 */
class Project extends Model
{
    use SoftDeletes, CascadeSoftDeletes;

    /** @var array */
    protected $guarded = ['code'];

    /** @var array */
    protected $hidden = ['code'];

    /** @var array */
    protected $dates = ['deleted_at'];

    /** @var array */
    protected $cascadeDeletes = ['issues'];

    /**
     * booted Method.
     *
     * @return void
     */
    protected static function booted()
    {
        static::saving(function (Project $project) {
            if (empty($project->title)) {
                $project->code = "NEW";
                return;
            }

            $parts = [];
            $title = trim($project->title);
            if (!Str::contains($title, " ")) {
                $parts[] = $title[0];
                $parts[] = $title[1];
            } else {
                $words = explode(" ", $title);
                $parts[] = $words[0][0];
                $parts[] = $words[1][0];
                empty($words[2]) ?: $parts[] = $words[2][0];
            }

            $suffix = !empty($parts[2]) ? $parts[2] : "";
            $project->code = strtoupper($parts[0] . $parts[1] . $suffix);
        });
    }

    /**
     * owner Method.
     *
     * @return BelongsTo
     */
    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id', 'id');
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


    /**
     * createRules Method.
     *
     * @return array
     */
    public static function validationRules()
    {
        return [
            'owner_id'    => ['required', 'integer', 'exists:'.User::class.',id'],
            'status_id'   => ['required', 'integer', 'exists:'.ProjectStatus::class.',id'],
            'title'       => ['required', 'string',  'max:150'],
            'description' => ['nullable', 'string'],
        ];
    }
}
