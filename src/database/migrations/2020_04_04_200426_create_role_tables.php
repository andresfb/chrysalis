<?php

use App\Models\Permission;
use App\Models\Role;
use Faker\Factory;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Class CreateRoleTables
 */
class CreateRoleTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->bigIncrements("id");
            $table->string("name", 100);
            $table->string("label")->nullable();
            $table->timestamps();
        });

        Schema::create('permissions', function (Blueprint $table) {
            $table->bigIncrements("id");
            $table->string("name", 100);
            $table->string("label")->nullable();
            $table->timestamps();
        });

        Schema::create('permission_role', function (Blueprint $table) {
            $table->primary(["role_id", "permission_id"]);
            $table->unsignedBigInteger("role_id");
            $table->unsignedBigInteger("permission_id");

            $table->foreign("role_id")
                ->references("id")
                ->on("roles")
                ->onDelete("cascade");

            $table->foreign("permission_id")
                ->references("id")
                ->on("permissions")
                ->onDelete("cascade");
        });

        Schema::create('role_user', function (Blueprint $table) {
            $table->primary(["role_id", "user_id"]);
            $table->unsignedBigInteger("user_id");
            $table->unsignedBigInteger("role_id");

            $table->foreign("user_id")
                ->references("id")
                ->on("users")
                ->onDelete("cascade");

            $table->foreign("role_id")
                ->references("id")
                ->on("roles")
                ->onDelete("cascade");
        });

        $faker = Factory::create();

        /** @var Permission $permission */
        $permission = Permission::create([
            'name' => 'full_access',
        ]);

        /** @var Role $role */
        $role = Role::create([
            'name'  => 'admin',
            'label' => 'Administrator'
        ]);
        $role->allowTo($permission);

        /** @var User $user */
        $user = User::create([
            'name' => $faker->name,
            'email' => 'admin@app.com',
            'password' => bcrypt($faker->text(32))
        ]);
        $user->assignRole($role);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('role_permission');
        Schema::dropIfExists('permissions');
        Schema::dropIfExists('role_user');
        Schema::dropIfExists('roles');
    }
}
