<?php

namespace Tests\Feature\Users;

use Spatie\Permission\Models\Role;
use Tests\BaseTests\CreateUsersCase;

class UserPromoteAdminAccessTest extends CreateUsersCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->user = $this->create_admin();

        $this->signIn($this->user);
    }

    /** @test */
    public function admin_can_promote_to_user()
    {
        $this->withoutExceptionHandling();

        $guest = $this->create_guest();

        $expected = 'user';

        $response = $this->post(route('user.promote'), [
            'owner_id' => $guest->id,
            'role'     => $expected
        ]);

        $response->assertOk();

        $guest = $guest->fresh();

        $this->assertFalse($guest->hasRole('guest'));

        $this->assertTrue($guest->hasRole($expected));
    }

    /** @test */
    public function admin_can_promote_to_manager()
    {
        $this->withoutExceptionHandling();

        $user = $this->create_user();

        $expected = 'manager';

        $response = $this->post(route('user.promote'), [
            'owner_id' => $user->id,
            'role'     => $expected
        ]);

        $response->assertOk();

        $user = $user->fresh();

        $this->assertFalse($user->hasRole('user'));

        $this->assertTrue($user->hasRole($expected));
    }
}
