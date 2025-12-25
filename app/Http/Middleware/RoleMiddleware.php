<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role): Response
    {
        if (!Auth::check()) {
            return redirect('/login');
        }

        $userRole = Auth::user()->role;

        // 1. If the route requires 'admin', allow 'admin' OR 'super_admin'
        if ($role === 'admin') {
            if ($userRole === 'admin' || $userRole === 'super_admin') {
                return $next($request);
            }
        }

        // 2. If the route requires 'super_admin', ONLY allow 'super_admin'
        if ($role === 'super_admin') {
            if ($userRole === 'super_admin') {
                return $next($request);
            }
        }

        // 3. If they don't match, kick them to the Client Portal
        return redirect()->route('client.portal');
    }
}
