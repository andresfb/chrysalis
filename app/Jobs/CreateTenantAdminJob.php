<?php

namespace App\Jobs;

use App\Models\Tenant;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CreateTenantAdminJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(private readonly Tenant $tenant)
    {
    }

    public function handle(): void
    {
        $this->tenant->run(function (Tenant $tenant) {

            $userData = $tenant->only(['name', 'email', 'password']);
            $userData['email_verified_at'] = now();

            $user = User::create($userData);

            event(new Registered($user));

        });

    }
}
