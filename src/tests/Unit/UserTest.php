<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_is_administrator()
    {
        $user = factory(User::class)->create();

        $role = Role::findByName('super-admin');

        $user->assignRole($role);

        $this->assertTrue($user->hasRole('super-admin'));
    }
}
