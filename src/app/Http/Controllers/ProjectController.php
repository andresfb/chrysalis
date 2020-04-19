<?php

namespace App\Http\Controllers;

use App\Http\Requests\Project\DeleteRequest;
use Exception;
use App\Models\Project;
use App\Services\ProjectService;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\Project\StoreRequest;
use App\Http\Requests\Project\UpdateRequest;

/**
 * Class ProjectController
 *
 * @package App\Http\Controllers
 */
class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreRequest $request
     * @param ProjectService $service
     * @return RedirectResponse
     */
    public function store(StoreRequest $request, ProjectService $service)
    {
        $attibutes = $service->checkAssignedOwner($request->validated());
        if (empty($attibutes)) {
            abort(403, $service->error);
        }

        $project = Project::create($attibutes);

        return redirect()->route('project.show', $project->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateRequest $request
     * @param Project $project
     * @return RedirectResponse
     */
    public function update(UpdateRequest $request, Project $project)
    {
        $project->update($request->validated());

        return redirect()->route('project.show', $project->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DeleteRequest $request
     * @param Project $project
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy(DeleteRequest $request, Project $project)
    {
        $project->delete();

        return redirect()->route('project.index');
    }
}
