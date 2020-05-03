<?php


namespace App\Services;

use App\Models\Issue;
use App\Models\User;

/**
 * Class IssueService
 *
 * @package App\Services
 */
class IssueService extends BaseService
{
    /**
     * checkAssignedOwner Method.
     *
     * @param array $issueData
     * @return array|bool
     */
    public function checkAssignedOwner(array $issueData)
    {
        $this->error = "";

        $user = User::find($issueData['assignee_id']);

        if ($user->hasRole('guest')) {
            $this->error = 'Issues needs a User access level or higher';
            return false;
        }

        return $issueData;
    }

    /**
     * canDelete Method.
     *
     * Allow Admin to delete an Issue
     * even if it has Tasks records.
     *
     * @param Issue $issue
     * @return bool
     */
    public function canDelete(Issue $issue)
    {
        if (auth()->user()->hasRole('admin')) {
            return true;
        }

        $this->error = "";

        if (!count($issue->tasks)) {
            return true;
        }

        $this->error = "Cannot delete Issue with existing Tasks";
        return false;
    }
}
