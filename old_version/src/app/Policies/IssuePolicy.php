<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Issue;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * Class IssuePolicy
 *
 * @package App\Policies
 */
class IssuePolicy
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
        return $user->can('read.issue');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param User $user
     * @param Issue $issue
     * @return mixed
     */
    public function view(User $user, Issue $issue)
    {
        return $user->can('read.issue');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param User $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->can('create.issue');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @param Issue $issue
     * @return mixed
     */
    public function update(User $user, Issue $issue)
    {
        return $user->hasRole('manager') ||
                ($user->can('update.issue.own') && $user->is($issue->assignee));
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param Issue $issue
     * @return mixed
     */
    public function delete(User $user, Issue $issue)
    {
        return $user->can('delete.issue');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param User $user
     * @param Issue $issue
     * @return mixed
     */
    public function restore(User $user, Issue $issue)
    {
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param User $user
     * @param Issue $issue
     * @return mixed
     */
    public function forceDelete(User $user, Issue $issue)
    {
        return $user->hasRole('admin');
    }
}
