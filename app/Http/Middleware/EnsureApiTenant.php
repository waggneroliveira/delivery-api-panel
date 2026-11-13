<?php

namespace App\Http\Middleware;

use App\Models\Tenant;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureApiTenant
{
    public function handle(Request $request, Closure $next): Response
    {
        $tenant = Tenant::current();

        if (!$tenant) {
            return response()->json(['message' => 'Cliente não encontrado.'], 404);
        }

        if (!$tenant->active) {
            return response()->json(['message' => 'Cliente inativo.'], 403);
        }

        return $next($request);
    }
}
