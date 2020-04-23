<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProjectCodeTest extends TestCase
{
    use RefreshDatabase;

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
}
