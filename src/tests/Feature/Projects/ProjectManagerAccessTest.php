<?php

namespace Tests\Feature\Projects;

use App\Models\Project;
use Tests\BaseTests\CreateUsersCase;

class ProjectManagerAccessTest extends CreateUsersCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->user = $this->create_manager();

        $this->signIn($this->user);
    }

    /** @test */
    public function manager_can_create_project_assigned_to_self()
    {
        $this->withoutExceptionHandling();

        $project = factory(Project::class)->raw(['owner_id' => $this->user->id]);

        $this->post(route('project.store'), $project);

        $this->assertDatabaseHas('projects', $project);
    }

    /** @test */
    public function manager_can_create_project_asssigned_to_manager()
    {
        $this->withoutExceptionHandling();

        $assignee = $this->create_manager();

        $project = factory(Project::class)->raw(['owner_id' => $assignee->id]);

        $this->post(route('project.store'), $project);

        $this->assertDatabaseHas('projects', $project);
    }

    /** @test */
    public function manager_cannot_create_project_assigned_to_nonmanager()
    {
        $assignee = $this->create_user();

        $project = factory(Project::class)->raw(['owner_id' => $assignee->id]);

        $this->post(route('project.store'), $project)->assertForbidden();

        $this->assertDatabaseMissing('projects', $project);
    }

    /** @test */
    public function manager_can_upate_its_own_project()
    {
        $this->withoutExceptionHandling();

        $project = factory(Project::class)->create(['owner_id' => $this->user->id]);

        $exptected = factory(Project::class)->raw(['owner_id' => $this->user->id]);

        $this->patch(route('project.update', [$project->id]), $exptected);

        $this->assertDatabaseHas('projects', $exptected);
    }

    /** @test */
    public function manager_cannot_update_others_project()
    {
        $assignee = $this->create_manager();

        $project = factory(Project::class)->create(['owner_id' => $assignee->id]);

        $exptected = factory(Project::class)->raw(['owner_id' => $this->user->id]);

        $this->patch(route('project.update', [$project->id]), $exptected)->assertForbidden();

        $this->assertDatabaseMissing('projects', $exptected);
    }
}
