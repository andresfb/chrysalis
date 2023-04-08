<?php

namespace App\Events\Project;

use App\Models\Project;
use Illuminate\Queue\SerializesModels;

class ProjectSavingEvent
{
    use SerializesModels;

    /**
     * @var Project
     */
    public $project;

    /**
     * Create a new event instance.
     *
     * @param Project $project
     */
    public function __construct(Project $project)
    {
        $this->project = $project;
    }
}
