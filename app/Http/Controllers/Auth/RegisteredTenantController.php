<?php

namespace App\Http\Controllers\Auth;

use App\DataTransferObjects\TenantCreateDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterTenantRequest;
use App\Models\Invitation;
use App\Services\Central\TenantCreateService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Request;
use Illuminate\View\View;

class RegisteredTenantController extends Controller
{
    public function create(Request $request): View
    {
        $token = $request->get('token');
        $invitation = Invitation::active($token)->firstOrFail();
        $data = [
            'name' => $invitation->name,
            'email' => $invitation->email,
            'token' => $invitation->token,
        ];

        return view('auth.register', compact('data'));
    }

    public function store(RegisterTenantRequest $request, TenantCreateService $service): RedirectResponse
    {
        $tenant = $service->create(
            TenantCreateDto::fromRequest($request)
        );

        $token = request('token', '');
        Invitation::redeemed($token);

        return redirect(tenant_route($tenant->domains->first()->domain, 'tenant.login'))
            ->with('success', 'Tenant created successfully');
    }
}
