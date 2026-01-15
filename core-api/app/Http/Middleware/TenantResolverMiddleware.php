<?php

namespace App\Http\Middleware;

use App\Models\Master\Tenant;
use App\Services\TenantConnectionService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TenantResolverMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $slug = $this->resolveTenantSlug($request);

        if (!$slug) {
            return response()->json(['message' => 'Tenant not resolved.'], 400);
        }

        $tenant = Tenant::on('master')
            ->where('slug', $slug)
            ->orWhere('domain', $request->getHost())
            ->first();

        if (!$tenant) {
            return response()->json(['message' => 'Tenant not found.'], 404);
        }

        app(TenantConnectionService::class)->setTenantContext($tenant);

        return $next($request);
    }

    private function resolveTenantSlug(Request $request): ?string
    {
        $header = $request->header('X-Tenant');
        if ($header) {
            return $header;
        }

        $host = $request->getHost();
        $parts = explode('.', $host);

        return count($parts) >= 3 ? $parts[0] : null;
    }
}
