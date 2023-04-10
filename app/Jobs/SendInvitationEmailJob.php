<?php

namespace App\Jobs;

use App\Mail\InvitationEmail;
use App\Models\Invitation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendInvitationEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(private readonly int $invitationId)
    {
    }

    public function handle(): void
    {
        $invite = Invitation::findOrFail($this->invitationId);
        $inviteUrl =
        Mail::to($invite->email)
            ->send(new InvitationEmail($invite->token));
    }
}
