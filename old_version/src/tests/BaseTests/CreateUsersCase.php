<?php

namespace Tests\BaseTests;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

/**
 * Class CreateUsersCase
 *
 * @package Tests\BaseTests
 */
class CreateUsersCase extends TestCase
{
    use RefreshDatabase;

    protected $user;

    /**
     * create_admin Method.
     *
     * @return Collection|Model|mixed
     */
    public function create_admin()
    {
        $user = factory(User::class)->create();

        $role = Role::findByName('admin');

        $user->assignRole($role);

        return $user;
    }

    /**
     * create_manager Method.
     *
     * @return Collection|Model|mixed
     */
    public function create_manager()
    {
        $user = factory(User::class)->create();

        $role = Role::findByName('manager');

        $user->assignRole($role);

        return $user;
    }

    /**
     * create_user Method.
     *
     * @return Collection|Model|mixed
     */
    public function create_user()
    {
        $user = factory(User::class)->create();

        $role = Role::findByName('user');

        $user->assignRole($role);

        return $user;
    }

    /**
     * create_guest Method.
     *
     * @return Collection|Model|mixed
     */
    public function create_guest()
    {
        $user = factory(User::class)->create();

        $role = Role::findByName('guest');

        $user->assignRole($role);

        return $user;
    }

    /**
     * signIn Method.
     *
     * @param null $user
     * @return Collection|Model|mixed|null
     */
    protected function signIn($user = null)
    {
        $user = $user ?: $this->create_user();

        $this->actingAs($user);

        return $user;
    }
}
