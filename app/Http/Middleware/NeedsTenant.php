<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Tenant;
use Spatie\Multitenancy\Contracts\IsTenant;

class NeedsTenant
{
    public function handle($request, Closure $next)
    {

        if (!app(IsTenant::class)::checkCurrent()) {

            return response()->view('client.tenant-error.404', [], 404);
        }

        $tenant = Tenant::current();

        if ($tenant->active == 0) {

            return response()->view('client.tenant-error.403', [], 403);
        }

        return $next($request);
    }
}
