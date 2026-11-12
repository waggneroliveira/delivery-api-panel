<?php

namespace App\Http\Middleware;

use App\Models\Client;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureClientApiAuthenticated
{
    public function handle(Request $request, Closure $next): Response
    {
        $client = Auth::guard('sanctum')->user();

        if (! $client instanceof Client) {
            return response()->json(['message' => 'Não autenticado.'], 401);
        }

        Auth::shouldUse('sanctum');

        return $next($request);
    }
}
