<?php

namespace Tests\Unit;

use App\Models\Permission;
use App\Models\Role;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_is_administrator()
    {
        $user = factory(User::class)->create();

        $permission = Permission::create([
            'name' => 'full_access',
        ]);

        $role = Role::create([
            'name'  => 'admin',
            'label' => 'Administrator'
        ]);
        $role->allowTo($permission);

        $user->assignRole($role);

        $this->assertTrue($user->isAdmin());
    }
}
