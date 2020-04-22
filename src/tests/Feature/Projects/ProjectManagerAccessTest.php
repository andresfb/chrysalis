<?php

namespace Tests\Feature\Projects;

use App\Models\Issue;
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
    public function manager_can_create_project_assigned_to_manager()
    {
        $this->withoutExceptionHandling();

        $assignee = $this->create_manager();

        $project = factory(Project::class)->raw(['owner_id' => $assignee->id]);

        $this->post(route('project.store'), $project);

        $this->assertDatabaseHas('projects', $project);
    }

    /** @test */
    public function manager_cannot_create_project_assigned_to_non_manager()
    {
        $assignee = $this->create_user();

        $project = factory(Project::class)->raw(['owner_id' => $assignee->id]);

        $this->post(route('project.store'), $project)
            ->assertSessionHas('error', 'Project needs a valid Manager');

        $this->assertDatabaseMissing('projects', $project);
    }

    /** @test */
    public function manager_can_update_its_own_project()
    {
        $this->withoutExceptionHandling();

        $project = factory(Project::class)->create(['owner_id' => $this->user->id]);

        $expected = factory(Project::class)->raw(['owner_id' => $this->user->id]);

        $this->patch(route('project.update', [$project->id]), $expected);

        $this->assertDatabaseHas('projects', $expected);
    }

    /** @test */
    public function manager_cannot_update_others_project()
    {
        $assignee = $this->create_manager();

        $project = factory(Project::class)->create(['owner_id' => $assignee->id]);

        $expected = factory(Project::class)->raw(['owner_id' => $this->user->id]);

        $this->patch(route('project.update', [$project->id]), $expected)->assertForbidden();

        $this->assertDatabaseMissing('projects', $expected);
    }

    /** @test */
    public function manager_can_soft_delete_own_project()
    {
        $this->withoutExceptionHandling();

        $project = factory(Project::class)->create(['owner_id' => $this->user->id]);

        $projectid = $project->id;

        $this->delete(route('project.destroy', [$projectid]));

        $project = Project::find($projectid);

        $this->assertNull($project);

        $project = Project::withTrashed()->where('id', $projectid)->get();

        $this->assertNotNull($project);
    }

    /** @test */
    public function manager_cannot_delete_others_project()
    {
        $assignee = $this->create_manager();

        $project = factory(Project::class)->create(['owner_id' => $assignee->id]);

        $this->delete(route('project.destroy', [$project->id]))->assertForbidden();

        $this->assertDatabaseMissing('projects', $project->toArray());
    }

    /** @test */
    public function manager_cannot_delete_own_project_with_issues()
    {
        $project = factory(Project::class)->create(['owner_id' => $this->user->id]);

        factory(Issue::class)->create(['project_id' => $project->id]);

        $this->delete(route('project.destroy', [$project->id]))
            ->assertSessionHas('error', 'Cannot Delete Project with existing Issues');

        $this->assertDatabaseMissing('projects', $project->toArray());
    }
}
