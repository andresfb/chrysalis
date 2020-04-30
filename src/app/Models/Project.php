<?php

namespace App\Models;

use App\Events\ProjectSaving;
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

    /** @var array */
    protected $dispatchesEvents = [
        'saving' => ProjectSaving::class,
    ];

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
