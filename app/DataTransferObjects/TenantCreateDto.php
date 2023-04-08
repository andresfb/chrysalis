<?php

namespace App\DataTransferObjects;

use App\Http\Requests\RegisterTenantRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class TenantCreateDto
{
    public readonly string $id;

    public function __construct(
        public string $company,
        public string $domain,
        public string $name,
        public string $email,
        public string $password,
    )
    {
        $this->id = Str::of($domain)->explode('.')->first();
        $this->password = Hash::make($this->password);
    }

    public static function fromRequest(RegisterTenantRequest $request): self
    {
        return new self(
            $request->company,
            $request->domain,
            $request->name,
            $request->email,
            $request->password,
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'company' => $this->company,
            'name' => $this->name,
            'email' => $this->email,
            'password' => $this->password,
        ];
    }
}
