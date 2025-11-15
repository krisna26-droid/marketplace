<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $roles = null)
    {
        // Pastikan ada user yang login
        $user = $request->user();

        if (!$user) {
            abort(403, 'Anda belum login.');
        }

        // Jika roles berupa string (misal "admin,vendor"), ubah jadi array
        $allowedRoles = explode(',', $roles);

        if (!in_array($user->role, $allowedRoles)) {
            abort(403, 'Akses ditolak.');
        }

        return $next($request);
    }
}
