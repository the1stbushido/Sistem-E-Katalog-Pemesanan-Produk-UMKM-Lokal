<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiRoleMiddleware
{
    /**
     * Handle an incoming request for API routes.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  ...$roles
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        $user = $request->user();

        // Check if user is authenticated
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthenticated.',
            ], 401);
        }

        // Check if user is approved
        if (!$user->is_approved) {
            return response()->json([
                'success' => false,
                'message' => 'Akun Anda sedang menunggu persetujuan.',
            ], 403);
        }

        // Check if user has required role
        foreach ($roles as $role) {
            if ($user->role === $role) {
                return $next($request);
            }
        }

        // User doesn't have required role
        return response()->json([
            'success' => false,
            'message' => 'Anda tidak memiliki hak akses untuk endpoint ini.',
        ], 403);
    }
}
