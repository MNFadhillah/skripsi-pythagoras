<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $role)
    {
        // Kalau user sudah logout, JANGAN tahan
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Kalau role tidak sesuai
        if (Auth::user()->role !== $role) {
            abort(403, 'Akses ditolak');
        }

        return $next($request);
    }

}
