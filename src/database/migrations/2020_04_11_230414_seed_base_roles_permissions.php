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
                'projects.create',
                'projects.read',
                'projects.update.own',
                'issues.create.owned',
                'issues.read',
                'issues.update.owned',
                'issues.delete.owned',
                'tasks.create.owned',
                'tasks.read',
                'tasks.update.owned',
                'tasks.delete.owned',
                'comments.create',
                'comments.read',
                'comments.update.own',
                'comments.delete.own',
                'tags.create',
                'tags.read',
                'tags.update.owned',
                'tags.delete.owned',
                'attachments.create.owned',
                'attachments.read',
                'attachments.update.owned',
                'attachments.delete.owned',
                'users.read',
                'users.update.own',
            ],
            'user' => [
                'projects.read',
                'issues.crate',
                'issues.read',
                'issues.update.own',
                'tasks.create.own',
                'tasks.read',
                'tasks.update.own',
                'comments.create',
                'comments.read',
                'comments.update.own',
                'comments.delete.own',
                'tags.create.owned',
                'tags.read',
                'tags.update.owned',
                'attachments.create.owned',
                'attachments.read',
                'attachments.update.own',
                'attachments.delete.own',
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
