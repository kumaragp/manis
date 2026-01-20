<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, $role)
    {
        $user = $request->user();

        if (!$user) {
            return redirect('/login');
        }

        if ($user->role === 'admin') {
            return $next($request);
        }

        if ($role === 'admin' && $user->role !== 'admin') {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        return $next($request);
    }
}