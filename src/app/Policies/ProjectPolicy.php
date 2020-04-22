<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Project;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * Class ProjectPolicy
 *
 * @package App\Policies
 */
class ProjectPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param User $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        if ($user->can('projects.read')) {
            return true;
        }

        return null;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param User $user
     * @param Project $project
     * @return mixed
     */
    public function view(User $user, Project $project)
    {
        if ($user->can('projects.read')) {
            return true;
        }

        return null;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param User $user
     * @return bool
     */
    public function create(User $user)
    {
        return $user->can('projects.create');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @param Project $project
     * @return bool
     */
    public function update(User $user, Project $project)
    {
        return ($user->can('projects.update.own') && $user->is($project->owner));
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param  Project  $project
     * @return mixed
     */
    public function delete(User $user, Project $project)
    {
        return $user->can('projects.delete.own') && $user->is($project->owner);
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param User $user
     * @return mixed
     */
    public function restore(User $user)
    {
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param User $user
     * @return mixed
     */
    public function forceDelete(User $user)
    {
        return $user->hasRole('admin');
    }
}
