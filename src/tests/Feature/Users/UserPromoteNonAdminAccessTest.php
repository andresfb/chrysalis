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

        $expected = 'admin';

        $this->post(route('user.promote'), [
            'owner_id' => $manager->id,
            'role'  => $expected
        ])->assertForbidden();

        $manager = $manager->fresh();

        $this->assertFalse($manager->hasRole($expected));

        $this->assertTrue($manager->hasRole('manager'));
    }

    /** @test */
    public function manager_cannot_demote_itself()
    {
        $manager = $this->create_manager();

        $this->signIn($manager);

        $expected = 'user';

        $this->post(route('user.promote'), [
            'owner_id' => $manager->id,
            'role'  => $expected
        ])->assertForbidden();

        $manager = $manager->fresh();

        $this->assertFalse($manager->hasRole($expected));

        $this->assertTrue($manager->hasRole('manager'));
    }

    /** @test */
    public function user_cannot_change_its_access()
    {
        $user = $this->create_user();

        $this->signIn($user);

        $expected = 'guest';

        $this->post(route('user.promote'), [
            'owner_id' => $user->id,
            'role'  => $expected
        ])->assertForbidden();

        $user = $user->fresh();

        $this->assertFalse($user->hasRole($expected));

        $this->assertTrue($user->hasRole('user'));
    }

    /** @test */
    public function guest_cannot_change_its_access()
    {
        $guest = $this->create_guest();

        $this->signIn($guest);

        $expected = 'user';

        $this->post(route('user.promote'), [
            'owner_id' => $guest->id,
            'role'  => $expected
        ])->assertForbidden();

        $guest = $guest->fresh();

        $this->assertFalse($guest->hasRole($expected));

        $this->assertTrue($guest->hasRole('guest'));
    }
}
