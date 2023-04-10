<?php

namespace App\Services\Central;

use App\DataTransferObjects\InvitationRequestDto;
use App\DataTransferObjects\ProcessResult;
use App\Jobs\SendInvitationEmailJob;
use App\Models\Invitation;

class InvitationService
{
    private array $matrix;

    public function __construct()
    {
        $this->matrix = config('invitation.ranges');
    }

    public function checkStatus(string $email): array
    {
        $invite = Invitation::firstWhere('email', $email);
        if (blank($invite)) {
            return [true, ''];
        }

        if (!blank($invite->registered_at)) {
            return ['false', "The invitation for $email was already redeemed "];
        }

        if (!blank($invite->expires_at->isPast())) {
            return [false, "The invitation for $email has expired "];
        }

        return [true, ''];
    }

    public function checkPrice(InvitationRequestDto $dto): array
    {
        $link = '';
        foreach ($this->matrix as $key => $value) {
            if ($dto->price < $this->matrix[$key]['prices']['min'] || $dto->price > $this->matrix[$key]['prices']['max']) {
                continue;
            }

            $link = $value['link'];
            break;
        }

        return [blank($link), $link];
    }

    public function sendRequest(InvitationRequestDto $dto): void
    {
        $invitation = Invitation::updateOrCreate(['email' => $dto->email], $dto->toArray());
        $dto->id = $invitation->id;
        $invitation->notify($dto);
    }

    public function createToken(Invitation $invite): array
    {
        $invite->generateToken();
        $invite->save();
        SendInvitationEmailJob::dispatch($invite->id);

        return [true, "Invitation sent to $invite->email"];
    }
}
