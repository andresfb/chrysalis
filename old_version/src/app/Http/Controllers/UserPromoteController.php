<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\UserPromoteRequest;
use App\Services\UserService;

/**
 * Class UserPromoteController
 *
 * @package App\Http\Controllers
 */
class UserPromoteController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param UserPromoteRequest $request
     * @param UserService $service
     * @return void
     */
    public function __invoke(UserPromoteRequest $request, UserService $service)
    {
        if (!$service->promote($request->validated())) {
            abort(403, $service->error);
        }

        back();
    }
}
