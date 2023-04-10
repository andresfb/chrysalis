<?php

namespace App\Http\Controllers\Auth;

use App\DataTransferObjects\TenantCreateDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterTenantRequest;
use App\Services\Central\TenantCreateService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class RegisteredTenantController extends Controller
{
    public function create(): View
    {
        return view('auth.register');
    }

    public function store(RegisterTenantRequest $request, TenantCreateService $service): RedirectResponse
    {
        $tenant = $service->create(
            TenantCreateDto::fromRequest($request)
        );

        return redirect(tenant_route($tenant->domains->first()->domain, 'tenant.login'))
            ->with('success', 'Tenant created successfully');
    }
}
