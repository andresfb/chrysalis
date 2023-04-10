<?php

namespace App\DataTransferObjects;

use App\Http\Requests\InvitationRequest;

class InvitationRequestDto
{
    public int $id = 0;

    public float $price = 0;

    public function __construct(
        public string $name,
        public string $email,
        string $price,
        public ?string $request_ip,
        public ?string $agent,
    ) {
        $this->price = (int) (((float) $price) * 100);
    }

    public static function fromRequest(InvitationRequest $request): self
    {
        return new self(
            $request->name,
            $request->email,
            $request->price,
            $request->ip(),
            $request->userAgent(),
        );
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
            'price' => $this->price,
            'request_ip' => $this->request_ip,
            'agent' => $this->agent,
        ];
    }
}
