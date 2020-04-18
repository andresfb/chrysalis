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
                $words = explode(" ", $title);
                $parts[] = $words[0][0];
                $parts[] = $words[1][0];
                empty($words[2]) ?: $parts[] = $words[2][0];
            }

            $sufix = !empty($parts[2]) ? $parts[2] : "";
            $project->code = strtoupper($parts[0] . $parts[1] . $sufix);
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
    public static function createRules()
    {
        $userclass = User::class;
        $statusclass = ProjectStatus::class;

        return [
            'owner_id'    => ['required', 'integer', "exists:{$userclass},id"],
            'status_id'   => ['required', 'integer', "exists:{$statusclass},id"],
            'title'       => ['required', 'string',  'max:150'],
            'description' => ['nullable', 'string'],
        ];
    }
}
