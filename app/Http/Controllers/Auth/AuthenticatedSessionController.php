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

        // Get the authenticated user
        $user = Auth::user();
        
        // Redirect based on user role
        $redirectRoute = match($user->role) {
            'superadmin' => 'superadmin.dashboard',
            'manager' => 'manager.dashboard', 
            'employee' => 'employee.dashboard',
            default => 'home',
        };

        return redirect()->intended(route($redirectRoute, absolute: false));
    }

    /**
     * Show the logout confirmation view.
     */
    public function showLogout(): View
    {
        return view('auth.logout');
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
