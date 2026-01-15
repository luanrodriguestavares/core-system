<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureTenantIsActiveMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $tenant = app('tenant');

        if (!$tenant || $tenant->status !== 'active') {
            return response()->json(['message' => 'Tenant is not active.'], 403);
        }

        return $next($request);
    }
}
