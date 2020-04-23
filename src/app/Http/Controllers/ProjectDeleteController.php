<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\Project\ForceDeleteRequest;

class ProjectDeleteController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param ForceDeleteRequest $request
     * @param Project $project
     * @return RedirectResponse
     */
    public function __invoke(ForceDeleteRequest $request, Project $project)
    {
        $project->forceDelete();

        return redirect()->route('project.index');
    }
}
