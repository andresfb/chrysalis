<?php

namespace App\Http\Middleware;

use App\Models\Invitation;
use Closure;
use Illuminate\Http\Request;

class HasInvitation
{
    public function handle(Request $request, Closure $next)
    {
         // Only for GET requests. Otherwise, this middleware will block our registration.
        if (!$request->isMethod('get')) {
            return $next($request);
        }

        // validate the request
        $validated = $request->validate([
            'token' => 'bail|required|string|alpha_num|size:40|exists:invitations,token'
        ]);

        $invitation = Invitation::whereToken($validated['token'])->first();

        // check if token hasn't expired.
        if ($invitation->expires_at->isPast()) {
            abort(403, 'The invitation has expired.');
        }

        // check if user already registered.
        if (!is_null($invitation->registered_at)) {
            abort(403, 'The invitation has already been used.');
        }

        return $next($request);
    }
}
