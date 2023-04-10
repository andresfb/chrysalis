<?php

namespace App\Http\Controllers\Central;

use App\Http\Controllers\Controller;
use App\Models\Invitation;
use App\Services\Central\InvitationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class InvitationReviewController extends Controller
{
    public function __construct(public readonly InvitationService $service)
    {
    }

    public function show(Request $request, Invitation $invitation)
    {
        if (!$request->hasValidSignature()) {
            abort(401);
        }

        $approveUrl = URL::temporarySignedRoute(
            'invitation.update',
            now()->addMinutes(30),
            ['invitation' => $invitation->id]
        );

        $rejectUrl = URL::temporarySignedRoute(
            'invitation.destroy',
            now()->addMinutes(30),
            ['invitation' => $invitation->id]
        );

        return view(
            'central.invitation.review',
            compact('invitation', 'approveUrl', 'rejectUrl')
        );
    }

    public function update(Request $request, Invitation $invitation): JsonResponse
    {
        if (!$request->hasValidSignature()) {
            abort(401);
        }

        $this->service->createToken($invitation);

        return response()->json('Invitation approved');
    }

    public function destroy(Request $request, Invitation $invitation): JsonResponse
    {
        if (!$request->hasValidSignature()) {
            abort(401);
        }

        $invitation->expires_at = now();
        $invitation->delete();

        return response()->json('Invitation rejected');
    }
}
