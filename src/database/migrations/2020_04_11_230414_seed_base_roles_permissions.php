<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class SeedBaseRolesPermissions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $rolesperms = [
            'manager' => [
                'projects.*',
                'issues.*',
                'tasks.*',
                'comments.*',
                'tags.*',
                'attachments.create',
                'attachments.read',
                'attachments.update',
                'users.read.*',
                'users.update.*',
            ],
            'user' => [
                'projects.read',
                'issues.crate',
                'issues.read',
                'issues.update',
                'tasks.*',
                'comments.create',
                'comments.read',
                'comments.delete',
                'tags.create',
                'tags.read',
                'tags.update',
                'attachments.create',
                'attachments.read',
                'attachments.update',
                'users.read.own',
                'users.update.own',
            ],
            'guest' => [
                'projects.read',
                'issues.read',
                'tasks.read',
                'comments.read',
                'tags.read',
                'attachments.read',
            ]
        ];

        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        foreach ($rolesperms as $role => $permissions) {

            $role = Role::findOrCreate($role);

            foreach ($permissions as $permission) {

                Permission::findOrCreate($permission);
                $role->givePermissionTo($permission);

            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {    }
}
