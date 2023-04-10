<?php

namespace App\Services\Central;

use App\DataTransferObjects\InvitationRequestDto;
use App\DataTransferObjects\ProcessResult;
use App\Models\Invitation;

class InvitationService
{
    private array $matrix;

    public function __construct()
    {
        $this->matrix = config('invitation.ranges');
    }

    public function check(InvitationRequestDto $dto): array
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
        $invitation = Invitation::updateOrCreate(['email' => $dto->email,], $dto->toArray());
        $dto->id = $invitation->id;
        $invitation->notify($dto);
    }

    public function createToken(InvitationRequestDto $dto): ProcessResult
    {
        $invite = Invitation::firstWhere('email', $dto->email);
        if (blank($invite)) {
            $invite = new Invitation();
        }

        if (!blank($invite->registered_at)) {
            return ProcessResult::create()
                ->setStatus(403)
                ->setMessage("The invitation for $dto->email was already redeemed ");
        }

        if (!blank($invite->expires_at->isPast())) {
            return ProcessResult::create()
                ->setStatus(405)
                ->setMessage("The invitation for $dto->email has expired ");
        }

        $invite->generateToken();
        $invite->save();
        $this->sendInvite($invite);

        return ProcessResult::create()
            ->setStatus(200)
            ->setMessage("Invitation sent to $dto->email");
    }

    private function sendInvite(Invitation $invite): void
    {

    }
}
