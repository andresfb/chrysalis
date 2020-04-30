<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\PromoteRequest;
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
     * @param PromoteRequest $request
     * @param UserService $service
     * @return void
     */
    public function __invoke(PromoteRequest $request, UserService $service)
    {
        if (!$service->promote($request->validated())) {
            abort(403, $service->error);
        }

        back();
    }
}
