<?php

namespace Tests\Feature\Projects;

use App\Models\Project;
use Tests\BaseTests\CreateUsersCase;

class ProjectAdminAccessTest extends CreateUsersCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->signIn($this->create_admin());
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
}
