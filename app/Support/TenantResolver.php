<?php

namespace App\Support;

use App\Models\Tenant;
use App\Models\User;
use Spatie\Multitenancy\Models\Tenant as BaseTenant;

class TenantResolver
{
    public function resolveFromUser(?User $user, ?BaseTenant $fallbackTenant = null): ?BaseTenant
    {
        if ($user?->tenant_id) {
            return Tenant::find($user->tenant_id);
        }

        return $fallbackTenant;
    }
}
