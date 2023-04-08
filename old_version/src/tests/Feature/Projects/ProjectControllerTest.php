<?php

namespace Tests\Feature\Projects;

use App\Models\Project;
use Tests\BaseTests\CreateUsersCase;

class ProjectControllerTest extends CreateUsersCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->user = $this->create_manager();

        $this->signIn($this->user);
    }

    /** @test */
    public function create_displays_view()
    {
        $this->withoutExceptionHandling();

        $response = $this->get(route('project.create'));

        $response->assertOk();

        $response->assertViewIs('project.create');
    }

    /**
     * @test
     */
    public function store_saves_and_redirects()
    {
        $this->withoutExceptionHandling();

        $project = factory(Project::class)->raw(['owner_id' => $this->user->id]);

        $response = $this->post(route('project.store'), $project);

        $this->assertDatabaseHas('projects', $project);

        $actual = Project::find(1);

        $this->assertNotNull($actual);

        $response->assertRedirect(route('project.show', [$actual->id]));
    }

    /**
     * @test
     */
    public function show_displays_view()
    {
        $this->withoutExceptionHandling();

        $project = factory(Project::class)->create();

        $response = $this->get(route('project.show', $project));

        $response->assertOk();

        $response->assertViewIs('project.show');

        $response->assertViewHas('project');
    }

    /**
     * @test
     */
    public function edit_displays_view()
    {
        $this->withoutExceptionHandling();

        $project = factory(Project::class)->create(['owner_id' => $this->user->id]);

        $response = $this->get(route('project.edit', $project));

        $response->assertOk();

        $response->assertViewIs('project.edit');

        $response->assertViewHas('project');
    }

    /**
     * @test
     */
    public function update_redirects()
    {
        $this->withoutExceptionHandling();

        $project = factory(Project::class)->create(['owner_id' => $this->user->id]);

        $expected = factory(Project::class)->raw(['owner_id' => $this->user->id]);

        $response = $this->patch(route('project.update', $project), $expected);

        $response->assertRedirect(route('project.show', $project));

        $response = $this->get(route('project.show', $project));

        $response->assertOk();

        $response->assertSeeText($expected['title']);
    }

    /**
     * @test
     */
    public function destroy_deletes_and_redirects()
    {
        $this->withoutExceptionHandling();

        $project = factory(Project::class)->create(['owner_id' => $this->user->id]);

        $response = $this->delete(route('project.destroy', $project));

        $response->assertRedirect(route('project.index'));

        $this->assertSoftDeleted($project);
    }
}
