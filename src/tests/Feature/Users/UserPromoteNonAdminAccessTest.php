<?php

namespace Tests\Feature\Users;

use Spatie\Permission\Models\Role;
use Tests\BaseTests\CreateUsersCase;

class UserPromoteNonAdminAccessTest extends CreateUsersCase
{
    /** @test */
    public function manager_cannot_promote_itself_to_admin()
    {
        $manager = $this->create_manager();

        $this->signIn($manager);

        $role = Role::where('name', 'admin')->first();

        $this->post(route('user.promote'), [
            'owner_id' => $manager->id,
            'role_id'  => $role->id
        ])->assertForbidden();

        $manager = $manager->fresh();

        $this->assertFalse($manager->hasRole('admin'));

        $this->assertTrue($manager->hasRole('manager'));
    }

    /** @test */
    public function manager_cannot_demote_itself()
    {
        $manager = $this->create_manager();

        $this->signIn($manager);

        $role = Role::where('name', 'user')->first();

        $this->post(route('user.promote'), [
            'owner_id' => $manager->id,
            'role_id'  => $role->id
        ])->assertForbidden();

        $manager = $manager->fresh();

        $this->assertFalse($manager->hasRole('user'));

        $this->assertTrue($manager->hasRole('manager'));
    }

    /** @test */
    public function user_cannot_change_its_access()
    {
        $user = $this->create_user();

        $this->signIn($user);

        $role = Role::where('name', 'guest')->first();

        $this->post(route('user.promote'), [
            'owner_id' => $user->id,
            'role_id'  => $role->id
        ])->assertForbidden();

        $user = $user->fresh();

        $this->assertFalse($user->hasRole('guest'));

        $this->assertTrue($user->hasRole('user'));
    }

    /** @test */
    public function guest_cannot_change_its_access()
    {
        $guest = $this->create_guest();

        $this->signIn($guest);

        $role = Role::where('name', 'user')->first();

        $this->post(route('user.promote'), [
            'owner_id' => $guest->id,
            'role_id'  => $role->id
        ])->assertForbidden();

        $guest = $guest->fresh();

        $this->assertFalse($guest->hasRole('user'));

        $this->assertTrue($guest->hasRole('guest'));
    }
}
