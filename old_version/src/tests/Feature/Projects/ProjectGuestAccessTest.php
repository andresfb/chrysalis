<?php

namespace Tests\Feature\Projects;

use App\Models\Project;
use Tests\BaseTests\CreateUsersCase;

class ProjectGuestAccessTest extends CreateUsersCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->user = $this->create_guest();

        $this->signIn($this->user);
    }

    /** @test */
    public function guest_can_list_projects()
    {
        $this->withoutExceptionHandling();

        $manager = $this->create_manager();

        factory(Project::class, 10)->create(['owner_id' => $manager->id]);

        $another_manager = $this->create_manager();

        $project = factory(Project::class)->create(['owner_id' => $another_manager->id]);

        $response = $this->get(route("project.index"));

        $response->assertStatus(200);

        $response->assertSee($project->title);
    }

    /** @test */
    public function guest_can_see_a_project()
    {
        $this->withoutExceptionHandling();

        $manager = $this->create_manager();

        $project = factory(Project::class)->create(['owner_id' => $manager->id]);

        $response = $this->get(route("project.show", [$project->id]));

        $response->assertStatus(200);

        $response->assertSee($project->title);
    }
}
