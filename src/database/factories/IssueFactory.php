<?php

/** @var Factory $factory */

use Carbon\Carbon;
use App\Models\User;
use App\Models\Issue;
use App\Models\Project;
use Faker\Generator as Faker;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Issue::class, function (Faker $faker) {
    $project = factory(Project::class)->create();
    $user = factory(User::class)->create();
    $role = Role::findByName('user');
    $user->assignRole($role);

    return [
        'project_id'  => $project->id,
        'assignee_id' => $user->id,
        'type_id'     => $faker->numberBetween(1, 4),
        'status_id'   => $faker->numberBetween(1, 4),
        'severity_id' => $faker->numberBetween(1, 5),
        'title'       => $faker->sentence,
        'description' => $faker->paragraph,
        'environment' => $faker->paragraphs(5, true),
        'due_date'    => Carbon::now()->addMonths(2),
    ];
});
