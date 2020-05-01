<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Project;
use Illuminate\View\View;
use App\Services\ProjectService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\Factory;
use App\Http\Requests\Project\ProjectStoreRequest;
use App\Http\Requests\Project\ProjectDeleteRequest;
use App\Http\Requests\Project\ProjectUpdateRequest;
use Illuminate\Contracts\Foundation\Application;

/**
 * Class ProjectController
 *
 * @package App\Http\Controllers
 */
class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $projects = Project::orderBy('created_at', 'DESC')->get();

        return view('project.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('project.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ProjectStoreRequest $request
     * @param ProjectService $service
     * @return RedirectResponse
     */
    public function store(ProjectStoreRequest $request, ProjectService $service)
    {
        $attributes = $service->checkAssignedOwner($request->validated());
        if (empty($attributes)) {
            back()->with('error', $service->error);
        }

        $project = Project::create($attributes);

        return redirect()->route('project.show', $project->id);
    }

    /**
     * Display the specified resource.
     *
     * @param Project $project
     * @return Application|Factory|View
     */
    public function show(Project $project)
    {
        return view('project.show', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Project $project
     * @return Application|Factory|View
     */
    public function edit(Project $project)
    {
        return view('project.edit', compact('project'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ProjectUpdateRequest $request
     * @param Project $project
     * @return RedirectResponse
     */
    public function update(ProjectUpdateRequest $request, Project $project)
    {
        $project->update($request->validated());

        return redirect()->route('project.show', $project->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param ProjectDeleteRequest $request
     * @param ProjectService $service
     * @param Project $project
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy(ProjectDeleteRequest $request, ProjectService $service, Project $project)
    {
        if (!$service->canDelete($project)) {
            back()->with('error', $service->error);
        }

        $project->delete();

        return redirect()->route('project.index');
    }
}
