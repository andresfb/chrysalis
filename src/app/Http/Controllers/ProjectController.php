<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Services\ProjectService;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\StoreProjectRequest;

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
     * @param StoreProjectRequest $request
     * @param ProjectService $service
     * @return RedirectResponse
     */
    public function store(StoreProjectRequest $request, ProjectService $service)
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
     * @param Request $request
     * @param  int  $id
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     */
    public function destroy($id)
    {
        //
    }
}
