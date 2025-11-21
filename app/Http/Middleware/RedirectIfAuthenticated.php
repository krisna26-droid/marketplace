<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        // Pastikan user sudah login
        if (Auth::check()) {

            // Kalau masih pending → logout & beri pesan
            if (Auth::user()->role === 'vendor_pending') {
                Auth::logout();
                return redirect()->route('login')
                    ->with('error', 'Akun vendor Anda sedang menunggu verifikasi admin.');
            }

            // Arahkan sesuai role yang valid
            return match (Auth::user()->role) {
                'admin'        => redirect()->route('admin.dashboard'),
                'vendor'       => redirect()->route('vendor.dashboard'),
                'customer'     => redirect()->route('customer.dashboard'),
                default        => redirect(RouteServiceProvider::HOME),
            };
        }

        return $next($request);
    }
}
