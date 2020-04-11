<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;

class Role
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @param array $roles
     * @return mixed
     */
    public function handle($request, Closure $next, ...$roles)
    {
        /** @var User $user */
        $user = auth()->user();

        if ($user->isAdmin()) {
            return $next($request);
        }

        foreach($roles as $role) {

            if ($user->roles->flatten()->pluck('name')->contains($role)) {
                return $next($request);
            }

        }

        return abort(403);
    }
}
