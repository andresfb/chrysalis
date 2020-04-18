<?php


namespace App\Services;

use App\Models\User;

/**
 * Class ProjectService
 *
 * @package App\Services
 */
class ProjectService
{
    /** @var string */
    public $error = "";

    /**
     * checkAssignedOwner Method.
     *
     * @param array $projectData
     * @return array|bool
     */
    public function checkAssignedOwner(array $projectData)
    {
        $this->error = "";

        $user = User::find($projectData['owner_id']);
        if ($user->hasRole('admin') || $user->hasRole('manager')) {
            return $projectData;
        }

        $this->error = 'Project needs a valid Manager';
        return false;
    }
}
