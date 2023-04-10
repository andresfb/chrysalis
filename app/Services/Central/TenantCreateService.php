<?php

namespace App\Services\Central;

use App\DataTransferObjects\TenantCreateDto;
use App\Models\Tenant;

class TenantCreateService
{
    public function create(TenantCreateDto $dto): Tenant
    {
        $tenant = Tenant::create($dto->toArray());

        $tenant->domains()->create([
            'domain' => $dto->domain,
        ]);

        return $tenant;
    }
}
