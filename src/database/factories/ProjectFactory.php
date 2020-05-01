<?php

/** @var Factory $factory */

use App\Models\Project;
use App\Models\ProjectStatus;
use App\Models\User;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;
use Spatie\Permission\Models\Role;

$factory->define(Project::class, function (Faker $faker) {
    $user = factory(User::class)->create();
    $role = Role::findByName('manager');
    $user->assignRole($role);
    $status = ProjectStatus::firstWhere('name', 'Active');

    return [
        'owner_id'    => $user->id,
        'status_id'   => $status->id,
        'title'       => $faker->sentence,
        'description' => $faker->paragraph
    ];
});
