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
     * @param  string  ...$roles
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!Auth::check()) {
            return redirect('login');
        }

        $user = Auth::user();

        // Jika user belum diapprove, kecuali superadmin
        if (!$user->is_approved && !$user->isSuperAdmin()) {
            Auth::logout();
            return redirect('login')->with('status', 'Akun Anda sedang menunggu persetujuan Super Admin.');
        }

        foreach ($roles as $role) {
            if ($user->role === $role && $user->is_approved) {
                return $next($request);
            }
        }
        
        // Jika tidak punya role yang diizinkan, kembalikan ke dashboard
        return redirect('/dashboard')->with('error', 'Anda tidak memiliki hak akses.');
    }
}