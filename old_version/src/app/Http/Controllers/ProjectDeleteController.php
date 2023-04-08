<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\Project\ProjectForceDeleteRequest;

/**
 * Class ProjectDeleteController
 *
 * @package App\Http\Controllers
 */
class ProjectDeleteController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param ProjectForceDeleteRequest $request
     * @param Project $project
     * @return RedirectResponse
     */
    public function __invoke(ProjectForceDeleteRequest $request, Project $project)
    {
        $project->forceDelete();

        return redirect()->route('project.index');
    }
}
