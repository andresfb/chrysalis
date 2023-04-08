<?php

namespace Tests\Feature\Projects;

use App\Models\Project;
use Tests\BaseTests\CreateUsersCase;

class ProjectUserAccessTest extends CreateUsersCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->user = $this->create_user();

        $this->signIn($this->user);
    }

    /** @test */
    public function user_cannot_create_project()
    {
        $project = factory(Project::class)->raw(['owner_id' => $this->user->id]);

        $this->post(route('project.store'), $project)->assertForbidden();

        $this->assertDatabaseMissing('projects', $project);
    }

    /** @test */
    public function user_cannot_update_project()
    {
        $assignee = $this->create_manager();

        $project = factory(Project::class)->create(['owner_id' => $assignee->id]);

        $expected = factory(Project::class)->raw(['owner_id' => $this->user->id]);

        $this->patch(route('project.update', [$project->id]), $expected)->assertForbidden();

        $this->assertDatabaseMissing('projects', $expected);
    }

    /** @test */
    public function user_cannot_delete_project()
    {
        $project = factory(Project::class)->create();

        $this->delete(route('project.destroy', [$project['id']]))->assertForbidden();

        $this->assertDatabaseMissing('projects', $project->toArray());
    }
}
