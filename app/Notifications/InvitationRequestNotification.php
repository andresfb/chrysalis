<?php

namespace App\Notifications;

use App\DataTransferObjects\InvitationRequestDto;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\SlackAttachment;
use Illuminate\Notifications\Messages\SlackMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\URL;

class InvitationRequestNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(private readonly InvitationRequestDto $invitation)
    {
    }

    public function via($notifiable): array
    {
        return ['slack'];
    }

    public function toSlack($notifiable): SlackMessage
    {
        $url = URL::signedRoute(
            'invitation.show',
            ['invitation' => $this->invitation->id]
        );

        return (new SlackMessage)
            ->content('New Invitation Requested')
            ->attachment(function (SlackAttachment $attachment) use ($url) {
                $attachment->title('Review', $url)
                    ->fields([
                        'Name' => $this->invitation->name,
                        'Email' => $this->invitation->email,
                        'RequestIp' => $this->invitation->request_ip,
                        'Agent' => $this->invitation->agent,
                        'Price' => number_format(($this->invitation->price / 100), 2),
                    ]);
            });
    }

    public function toArray($notifiable): array
    {
        return [];
    }
}
