<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Project;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProjectCodeTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function project_assigns_a_code()
    {
        $created = factory(Project::class)->create(['title' => 'Manifolds']);

        $found = Project::find($created->id);

        $this->assertNotNull($found);

        $this->assertNotEmpty($found->code);

        $code = "MA";

        $this->assertEquals($code, $found->code);

        $created = factory(Project::class)->create(['title' => 'El projecto']);

        $found = Project::find($created->id);

        $code = "EP";

        $this->assertEquals($code, $found->code);

        $created = factory(Project::class)->create(['title' => 'The Content Store']);

        $found = Project::find($created->id);

        $code = "TCS";

        $this->assertEquals($code, $found->code);
    }

    /** @test */
    public function projects_updates_the_code_field()
    {
        $created = factory(Project::class)->create(['title' => 'Manifolds']);

        $project = Project::find($created->id);

        $project->title = "Lightning Round";

        $project->save();

        $project->fresh();

        $code = "LR";

        $this->assertEquals($code, $project->code);
    }

    /** @test */
    public function project_keeps_same_code_when_updating_non_title_fields()
    {
        $created = factory(Project::class)->create();

        $project = Project::find($created->id);

        $project->description = $this->faker->paragraph;

        $project->save();

        $project->fresh();

        $this->assertEquals($created->code, $project->code);
    }

    /** @test */
    public function project_can_handle_duplicate_code()
    {
        $created = factory(Project::class)->create(['title' => 'Midtown Manhattan']);

        $project = Project::find($created->id);

        $this->assertEquals("MM", $project->code);

        $expected = factory(Project::class)->create(['title' => 'Maria Magdalene']);

        $project = Project::find($expected->id);

        $this->assertEquals("MM1", $project->code);
    }
}
