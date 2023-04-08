<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Issue;
use App\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;

class IssueNumberTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function issue_gets_the_correct_number()
    {
        $project = factory(Project::class)->create();

        $issue = factory(Issue::class)->create(['project_id' => $project->id]);

        $expected = sprintf("%s-%s", $project->code, 1);

        $this->assertEquals($expected, $issue->number);

        $issue2 = factory(Issue::class)->create(['project_id' => $project->id]);

        $expected = sprintf("%s-%s", $project->code, 2);

        $this->assertEquals($expected, $issue2->number);

        $issue->delete();

        $issue3 = factory(Issue::class)->create(['project_id' => $project->id]);

        $expected = sprintf("%s-%s", $project->code, 3);

        $this->assertEquals($expected, $issue3->number);
    }
}
