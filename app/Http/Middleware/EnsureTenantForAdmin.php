<?php

namespace App\Http\Middleware;

use App\Models\Tenant;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Multitenancy\Actions\MakeTenantCurrentAction;

class EnsureTenantForAdmin
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        if ($user instanceof User && !$user->tenant_id) {
            return $next($request);
        }

        if ($user instanceof User && $user->tenant_id) {
            $tenant = Tenant::find($user->tenant_id);

            if ($tenant) {
                app(MakeTenantCurrentAction::class)->execute($tenant);
            }
        }

        return $next($request);
    }
}
