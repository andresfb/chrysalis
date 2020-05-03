<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Issue;
use App\Models\Project;
use Illuminate\View\View;
use App\Services\IssueService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\Factory;
use App\Http\Requests\Issue\IssueStoreRequest;
use App\Http\Requests\Issue\IssueUpdateRequest;
use App\Http\Requests\Issue\IssueDeleteRequest;
use Illuminate\Contracts\Foundation\Application;

/**
 * Class IssueController
 *
 * @package App\Http\Controllers
 */
class IssueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Project $project
     * @return Application|Factory|View
     */
    public function index(Project $project)
    {
        $issues = $project->issues;

        return view('project.index', compact('issues'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Project $project
     * @return Application|Factory|View
     */
    public function create(Project $project)
    {
        return view('issue.create', compact('project'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param IssueStoreRequest $request
     * @param IssueService $service
     * @return RedirectResponse
     */
    public function store(IssueStoreRequest $request, IssueService $service)
    {
        $attributes = $service->checkAssignedOwner($request->validated());
        if (empty($attributes)) {
            back()->with('error', $service->error);
        }

        $issue = Issue::create($attributes);

        return redirect()->route('issue.show', $issue->id);
    }

    /**
     * Display the specified resource.
     *
     * @param Issue $issue
     * @return Application|Factory|View
     */
    public function show(Issue $issue)
    {
        return view('issue.show', compact('issue'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Issue $issue
     * @return Application|Factory|View
     */
    public function edit(Issue $issue)
    {
        return view('issue.edit', compact('issue'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param IssueUpdateRequest $request
     * @param Issue $issue
     * @return RedirectResponse
     */
    public function update(IssueUpdateRequest $request, Issue $issue)
    {
        $issue->update($request->validated());

        return redirect()->route('issue.show', $issue->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param IssueDeleteRequest $request
     * @param IssueService $service
     * @param Issue $issue
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy(IssueDeleteRequest $request, IssueService $service, Issue $issue)
    {
        if (!$service->canDelete($issue)) {
            back()->with('error', $service->error);
        }

        $issue->delete();

        return redirect()->route('issue.index', [$issue->project_id]);
    }
}
