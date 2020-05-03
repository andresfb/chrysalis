<?php

namespace App\Http\Controllers;

use App\Models\Issue;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\Issue\IssueForceDeleteRequest;

/**
 * Class IssueDeleteController
 *
 * @package App\Http\Controllers
 */
class IssueDeleteController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param IssueForceDeleteRequest $request
     * @param Issue $issue
     * @return RedirectResponse
     */
    public function __invoke(IssueForceDeleteRequest $request, Issue $issue)
    {
        $issue->forceDelete();

        return redirect()->route('issue.index', [$issue->project_id]);
    }
}
