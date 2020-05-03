<?php

/** @var Factory $factory */

use App\Models\Issue;
use App\Models\Task;
use App\Models\User;
use Faker\Generator as Faker;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Task::class, function (Faker $faker) {
    $user = factory(User::class)->create();
    $role = Role::findByName('user');
    $user->assignRole($role);

    return [
        'issue_id'    => factory(Issue::class),
        'assignee_id' => $user->id,
        'status_id'   => $faker->numberBetween(1, 4),
        'priority_id' => $faker->numberBetween(1, 5),
        'title'       => $faker->sentence,
        'description' => $faker->paragraph,
    ];
});
