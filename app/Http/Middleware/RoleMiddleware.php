<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string|int  ...$roles
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();
        $userRole = (string) $user->role_id;

        $allowedRoles = array_map(function ($r) {
            if ($r === 'superadmin' || $r === '1') return '1';
            if ($r === 'admin' || $r === '2') return '2';
            return (string) $r;
        }, $roles);

        if (!in_array($userRole, $allowedRoles)) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Akses ditolak.'], 403);
            }
            abort(403, 'Akses ditolak: Anda tidak memiliki wewenang untuk membuka halaman ini.');
        }

        return $next($request);
    }
}
