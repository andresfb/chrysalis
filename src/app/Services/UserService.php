<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

/**
 * Class UserService
 *
 * @package App\Services
 */
class UserService extends BaseService
{
    /**
     * promote Method.
     *
     * @param array $userData
     * @return bool
     */
    public function promote(array $userData)
    {
        $loggedUser = auth()->user();
        // users and guest cannot promote anyone
        if ($loggedUser->hasRole('user') || $loggedUser->hasRole('guest')) {
            $this->error = "You can't promote access";
            return false;
        }

        $role = Role::find($userData['role_id']);
        // non Admins cannot promote anyone to Admin
        if (!$loggedUser->hasRole('admin') && $role->name == 'admin') {
            $this->error = "You can't promote to Administrator";
            return false;
        }

        $user = User::find($userData['owner_id']);
        // if user already has the given access no need to update the record
        if ($user->hasRole($role->name)) {
            return true;
        }

        // managers can't demote their access
        if ($user->hasRole('manager') && ($role->name == 'user' || $role->name == 'guest')) {
            $this->error = "You can't demote your access";
            return false;
        }

        // remove old role and assign the new one
        $user->syncRoles($role);
        return true;
    }
}
