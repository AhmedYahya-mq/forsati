<?php

namespace App\Http\Controllers\AuthAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Events\AdminLoggedIn;
use App\Events\AdminLoggedOut;

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

        $request->authenticate("admin");

        // سجل الحدث عند تسجيل الدخول
        event(new AdminLoggedIn(Auth::guard('admin')->user())); // Dispatch الحدث
        $request->session()->regenerate();
        return redirect()->intended(route('dashboard', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $user = Auth::guard('admin')->user();

        Auth::guard('admin')->logout();

        event(new AdminLoggedOut($user));

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
