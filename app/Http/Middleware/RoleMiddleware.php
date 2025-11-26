<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $role)
    {
        // Pastikan user sudah login
        if (!$request->user()) {
            return redirect()->route('login');
        }

        // Cek role
        if ($request->user()->role !== $role) {
            return abort(403, 'Akses ditolak. Anda tidak memiliki role yang sesuai.');
        }

        return $next($request);
    }
}
