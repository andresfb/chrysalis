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
        $permissions = [
            'attachments.create.*',
            'attachments.read.*',
            'attachments.update.*',
            'attachments.delete.*',
            'comments.create.*',
            'comments.read.*',
            'comments.update.*',
            'comments.delete.*',
            'issues.create.*',
            'issues.read.*',
            'issues.update.*',
            'issues.delete.*',
            'projects.create.*',
            'projects.read.*',
            'projects.update.*',
            'projects.delete.*',
            'tags.create.*',
            'tags.read.*',
            'tags.update.*',
            'tags.delete.*',
            'tasks.create.*',
            'tasks.read.*',
            'tasks.update.*',
            'tasks.delete.*',
            'users.create.*',
            'users.read.*',
            'users.update.*',
            'users.delete.*',
        ];

        $rolesperms = [
            'manager' => [
                'projects.create.*',
                'projects.read.*',
                'projects.update.own',
                'projects.delete.own',
                'issues.create.*',
                'issues.read.*',
                'issues.update.*',
                'issues.delete.*',
                'tasks.create.*',
                'tasks.read.*',
                'tasks.update.*',
                'tasks.delete.*',
                'comments.create',
                'comments.read',
                'comments.update.own',
                'comments.delete.own',
                'tags.create.*',
                'tags.read.*',
                'tags.update.*',
                'tags.delete.*',
                'attachments.create.*',
                'attachments.read',
                'attachments.update.*',
                'attachments.delete.*',
                'users.read.*',
                'users.update.own',
            ],
            'user' => [
                'projects.read.*',
                'issues.crate.*',
                'issues.read.*',
                'issues.update.own',
                'tasks.create.own',
                'tasks.read.*',
                'tasks.update.own',
                'comments.create',
                'comments.read.*',
                'comments.update.own',
                'comments.delete.own',
                'tags.create.*',
                'tags.read.*',
                'tags.update.*',
                'attachments.create.*',
                'attachments.read',
                'attachments.update.own',
                'attachments.delete.own',
                'users.read.own',
                'users.update.own',
            ],
            'guest' => [
                'projects.read.*',
                'issues.read.*',
                'tasks.read.*',
                'comments.read.*',
                'tags.read.*',
                'attachments.read.*',
            ]
        ];

        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        foreach ($permissions as $permission) {

            Permission::findOrCreate($permission);
        }

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
