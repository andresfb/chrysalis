<?php

namespace App\Policies;

use App\Models\User;
use App\Models\User as ModelUser;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * Class UserPolicy
 *
 * @package App\Policies
 */
class UserPolicy
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
        return $user->can('read.user');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param User $user
     * @param  ModelUser  $model
     * @return mixed
     */
    public function view(User $user, ModelUser $model)
    {
        return $user->can('read.user.own') && $user->is($model);
    }

    /**
     * Determine whether the user can create models.
     *
     * @param ModelUser $user
     * @return mixed
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @param ModelUser $model
     * @return mixed
     */
    public function update(User $user, ModelUser $model)
    {
        return $user->can('update.user.own') && $user->is($model);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param  ModelUser  $model
     * @return mixed
     */
    public function delete(User $user, ModelUser $model)
    {
        return $user->can('delete.project.own') && $user->is($model);
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param User $user
     * @param  ModelUser  $model
     * @return mixed
     */
    public function restore(User $user, ModelUser $model)
    {
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param User $user
     * @param  ModelUser  $model
     * @return mixed
     */
    public function forceDelete(User $user, ModelUser $model)
    {
        return $user->hasRole('admin');
    }
}
