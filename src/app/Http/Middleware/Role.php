<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

/**
 * Class Role
 *
 * @package App\Http\Middleware
 */
class Role
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @param array<int,mixed> $roles
     * @return mixed
     */
    public function handle($request, Closure $next, ...$roles)
    {
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
