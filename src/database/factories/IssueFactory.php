<?php

/** @var Factory $factory */

use App\Models\Issue;
use App\Models\Project;
use App\Models\User;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Issue::class, function (Faker $faker) {
    $project = factory(Project::class)->create();
    $user = factory(User::class)->create();
    return [
        'project_id'   => $project->id,
        'assignee_id'  => $user->id,
        'type_id'      => $faker->numberBetween(1, 4),
        'status_id'    => $faker->numberBetween(1, 4),
        'severity_id'  => $faker->numberBetween(1, 5),
        'code'         => $faker->text(5),
        'title'        => $faker->sentence,
        'description'  => $faker->paragraph,
        'environment'  => $faker->paragraph,
        'due_date'     => $faker->dateTime
    ];
});
