<?php

namespace Tests\Feature\Projects;

use App\Models\Issue;
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

        $expected = factory(Project::class)->raw(['owner_id' => $this->user->id]);

        $actual = Project::create($expected);

        $this->delete(route('project.destroy', [$actual->id]));

        $this->assertDatabaseHas('projects', $expected);

        $project = Project::withTrashed()->where('id', $actual->id)->get();

        $this->assertNotNull($project);
    }

    /** @test */
    public function admin_can_soft_delete_any_project_with_issues()
    {
        $this->withoutExceptionHandling();

        $expected = factory(Project::class)->raw(['owner_id' => $this->user->id]);

        $actual = Project::create($expected);

        $issue = factory(Issue::class)->raw(['project_id' => $actual->id]);

        $actual->issues()->create($issue);

        $this->delete(route('project.destroy', [$actual->id]));

        $this->assertDatabaseHas('projects', $expected);

        $this->assertDatabaseHas('issues', $issue);

        $project = Project::withTrashed()->where('id', $actual->id)->get();

        $this->assertNotNull($project);

        $issue = Issue::withTrashed()->where('project_id', $actual->id);

        $this->assertNotNull($issue);
    }

    /** @test */
    public function admin_can_force_delete_any_project()
    {
        $this->withoutExceptionHandling();

        $expected = factory(Project::class)->raw(['owner_id' => $this->user->id]);

        $actual = Project::create($expected);

        $issue = factory(Issue::class)->raw(['project_id' => $actual->id]);

        $actual->issues()->create($issue);

        $this->delete(route('project.delete', [$actual->id]));

        $this->assertDatabaseMissing('projects', $expected);

        $this->assertDatabaseMissing('issues', $issue);
    }
}
