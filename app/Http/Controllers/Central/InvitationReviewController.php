<?php

namespace App\Http\Controllers\Central;

use App\Http\Controllers\Controller;
use App\Models\Invitation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class InvitationReviewController extends Controller
{
    public function show(Request $request, Invitation $invitation)
    {
        // TODO enable this
//        if (!$request->hasValidSignature()) {
//            abort(401);
//        }

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

    public function update(Request $request, Invitation $invitation)
    {
        // TODO implement the invitation approval
    }

    public function destroy(Request $request, Invitation $invitation)
    {
        // TODO implement the invitation rejection
    }
}
