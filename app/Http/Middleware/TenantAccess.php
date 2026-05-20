<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TenantAccess
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (!$user) {
            return redirect()->route('login');
        }

        // Super admin has no tenant restriction
        if ($user->isSuperAdmin()) {
            return $next($request);
        }

        // User must have a tenant
        if (!$user->tenant_id) {
            abort(403, 'Anda tidak terdaftar pada tenant manapun.');
        }

        // Check if tenant is active
        $tenant = $user->tenant;
        if (!$tenant || !$tenant->isActive()) {
            auth()->logout();
            return redirect()->route('login')
                ->with('error', 'Toko Anda sedang tidak aktif. Hubungi administrator.');
        }

        // Share tenant globally
        view()->share('currentTenant', $tenant);

        return $next($request);
    }
}
