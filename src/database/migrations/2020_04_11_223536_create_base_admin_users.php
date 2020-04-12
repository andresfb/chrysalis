<?php

use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;
use Illuminate\Database\Migrations\Migration;

class CreateBaseAdminUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // gets all permissions via Gate::before rule; see AuthServiceProvider
        $role = Role::create(['name' => 'super-admin']);

        // create admin user
        $user = Factory(User::class)->create([
            'email' => 'admin@app.com',
        ]);

        // assign super-admin role
        $user->assignRole($role);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {    }
}
