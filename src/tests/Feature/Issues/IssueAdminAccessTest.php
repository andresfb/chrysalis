<?php

namespace Tests\Feature\Issues;

use App\Models\Issue;
use App\Models\Project;
use App\Models\Task;
use Tests\BaseTests\CreateUsersCase;

class IssueAdminAccessTest extends CreateUsersCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->user = $this->create_admin();

        $this->signIn($this->user);
    }

    /** @test */
    public function admin_can_create_any_issue()
    {
        $this->withoutExceptionHandling();

        $issue = factory(Issue::class)->raw();

        $this->post(route('issue.store'), $issue);

        $this->assertDatabaseHas('issues', $issue);
    }

    /** @test */
    public function admin_can_update_any_issue()
    {
        $this->withoutExceptionHandling();

        $project = factory(Project::class)->create();

        $issue = factory(Issue::class)->create(['project_id' => $project->id]);

        $user = $this->create_user();

        $expected = factory(Issue::class)->raw([
            'project_id'  => $project->id,
            'assignee_id' => $user->id
        ]);

        $this->patch(route('issue.update', [$issue->id]), $expected);

        $this->assertDatabaseHas('issues', $expected);
    }

    /** @test */
    public function admin_can_soft_delete_any_issue()
    {
        $this->withoutExceptionHandling();

        $expected = factory(Issue::class)->raw();

        $actual = Issue::create($expected);

        $this->delete(route('issue.destroy', [$actual->id]));

        $this->assertDatabaseHas('issues', $expected);

        $issue = Project::withTrashed()->where('id', $actual->id)->get();

        $this->assertNotNull($issue);
    }

    /** @test */
    public function admin_can_soft_delete_any_issue_with_tasks()
    {
        $this->withoutExceptionHandling();

        $expected = factory(Issue::class)->raw();

        $actual = Issue::create($expected);

        $task = factory(Task::class)->raw(['issue_id' => $actual->id]);

        $actual->tasks()->create($task);

        $this->delete(route('issue.destroy', [$actual->id]));

        $this->assertDatabaseHas('issues', $expected);

        $this->assertDatabaseHas('tasks', $task);

        $issue = Issue::withTrashed()->where('id', $actual->id)->get();

        $this->assertNotNull($issue);

        $task = Task::withTrashed()->where('issue_id', $actual->id);

        $this->assertNotNull($task);
    }

    /** @test */
    public function admin_can_force_delete_any_issue()
    {
        $this->withoutExceptionHandling();

        $expected = factory(Issue::class)->raw();

        $actual = Issue::create($expected);

        $task = factory(Task::class)->raw(['issue_id' => $actual->id]);

        $actual->tasks()->create($task);

        $this->delete(route('issue.delete', [$actual->id]));

        $this->assertDatabaseMissing('issues', $expected);

        $this->assertDatabaseMissing('tasks', $task);
    }
}
