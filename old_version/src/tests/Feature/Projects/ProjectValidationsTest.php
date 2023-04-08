<?php

namespace Tests\Feature\Projects;

use App\Models\Project;
use Illuminate\Support\Str;
use Tests\BaseTests\CreateUsersCase;

class ProjectValidationsTest extends CreateUsersCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->user = $this->create_manager();

        $this->signIn($this->user);
    }

    /** @test */
    public function user_id_is_required()
    {
        $project = factory(Project::class)->raw(['owner_id' => null]);

        $this->post(route('project.store'), $project)->assertSessionHasErrors('owner_id');
    }

    /** @test */
    public function owner_id_must_be_integer()
    {
        $project = factory(Project::class)->raw(['owner_id' => "aaa"]);

        $this->post(route('project.store'), $project)->assertSessionHasErrors('owner_id');
    }

    /** @test */
    public function owner_must_exists()
    {
        $project = factory(Project::class)->raw(['owner_id' => 9999]);

        $this->post(route('project.store'), $project)->assertSessionHasErrors('owner_id');
    }

    /** @test */
    public function status_id_is_required()
    {
        $project = factory(Project::class)->raw(['status_id' => null]);

        $this->post(route('project.store'), $project)->assertSessionHasErrors('status_id');
    }

    /** @test */
    public function status_id_must_be_integer()
    {
        $project = factory(Project::class)->raw(['status_id' => "aaa"]);

        $this->post(route('project.store'), $project)->assertSessionHasErrors('status_id');
    }

    /** @test */
    public function status_must_exists()
    {
        $project = factory(Project::class)->raw(['status_id' => 9999]);

        $this->post(route('project.store'), $project)->assertSessionHasErrors('status_id');
    }

    /** @test */
    public function title_is_required()
    {
        $project = factory(Project::class)->raw(['title' => null]);

        $this->post(route('project.store'), $project)->assertSessionHasErrors('title');
    }

    /** @test */
    public function title_must_be_a_string()
    {
        $project = factory(Project::class)->raw(['title' => 9]);

        $this->post(route('project.store'), $project)->assertSessionHasErrors('title');
    }

    /** @test */
    public function title_must_be_at_most_150_characters()
    {
        $project = factory(Project::class)->raw([
            'title' => Str::random(151)
        ]);

        $this->post(route('project.store'), $project)->assertSessionHasErrors('title');
    }

    /** @test */
    public function description_must_be_string()
    {
        $project = factory(Project::class)->raw(['description' => 9]);

        $this->post(route('project.store'), $project)->assertSessionHasErrors('description');
    }
}
