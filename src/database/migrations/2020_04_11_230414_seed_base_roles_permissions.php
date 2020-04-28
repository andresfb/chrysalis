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
            'create.attachment.*',
            'read.attachment.*',
            'update.attachment.*',
            'delete.attachment.*',
            'create.comment.*',
            'read.comment.*',
            'update.comment.*',
            'delete.comment.*',
            'create.issue.*',
            'read.issue.*',
            'update.issue.*',
            'delete.issue.*',
            'create.project.*',
            'read.project.*',
            'update.project.*',
            'delete.project.*',
            'create.tag.*',
            'read.tag.*',
            'update.tag.*',
            'delete.tag.*',
            'create.task.*',
            'read.task.*',
            'update.task.*',
            'delete.task.*',
            'create.user.*',
            'read.user.*',
            'update.user.*',
            'delete.user.*',
        ];

        $rolesperms = [
            'manager' => [
                'create.project.*',
                'read.project.*',
                'update.project.own',
                'delete.project.own',
                'create.issue.*',
                'read.issue.*',
                'update.issue.*',
                'delete.issue.*',
                'create.task.*',
                'read.task.*',
                'update.task.*',
                'delete.task.*',
                'create.comment.*',
                'read.comment.*',
                'update.comment.own',
                'delete.comment.own',
                'create.tag.*',
                'read.tag.*',
                'update.tag.*',
                'delete.tag.*',
                'create.attachment.*',
                'read.attachment.*',
                'update.attachment.*',
                'delete.attachment.*',
                'read.user.*',
                'update.user.own',
            ],
            'user' => [
                'read.project.*',
                'crate.issue.*',
                'read.issue.*',
                'update.issue.own',
                'create.task.own',
                'read.task.*',
                'update.task.own',
                'create.comment.*',
                'read.comment.*',
                'update.comment.own',
                'delete.comment.own',
                'create.tag.*',
                'read.tag.*',
                'update.tag.*',
                'create.attachment.*',
                'read.attachment.*',
                'update.attachment.own',
                'delete.attachment.own',
                'read.user.own',
                'update.user.own',
            ],
            'guest' => [
                'read.project.*',
                'read.issue.*',
                'read.task.*',
                'read.comment.*',
                'read.tag.*',
                'read.attachment.*',
            ],
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
