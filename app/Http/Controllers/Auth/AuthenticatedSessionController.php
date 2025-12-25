<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        // 1. Get the role from the User
        $role = $request->user()->role;

        // 2. Redirect based on role
        if ($role === 'super_admin') {
            return redirect()->intended(route('super_admin.dashboard'));
        }
        elseif ($role === 'admin') {
            // The Agency Dashboard we built (Midnight Theme)
            return redirect()->intended(route('dashboard'));
        }

        // 3. Default: Regular Client Portal (We need to build this next)
        // For now, you can send them to 'dashboard' too, or a specific client page
        return redirect()->intended(route('dashboard'));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
