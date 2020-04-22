<?php

namespace Tests\Feature\Projects;

use App\Models\Project;
use Tests\BaseTests\CreateUsersCase;

class ProjectAdminAccessTest extends CreateUsersCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->user = $this->create_admin();

        $this->signIn($this->user);
    }

    /** @test */
    public function admin_can_create_any_project()
    {
        $this->withoutExceptionHandling();

        $manager = $this->create_manager();

        $project = factory(Project::class)->raw(['owner_id' => $manager->id]);

        $this->post(route('project.store'), $project);

        $this->assertDatabaseHas('projects', $project);
    }

    /** @test */
    public function admin_can_update_any_project()
    {
        $this->withoutExceptionHandling();

        $manager = $this->create_manager();

        $project = factory(Project::class)->create(['owner_id' => $manager->id]);

        $newmanager = $this->create_manager();

        $expected = factory(Project::class)->raw(['owner_id' => $newmanager->id]);

        $this->patch(route('project.update', [$project->id]), $expected);

        $this->assertDatabaseHas('projects', $expected);
    }

    /** @test */
    public function admin_can_soft_delete_any_project()
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
}
