<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class EmailVerificationNotificationController extends Controller
{
    /**
     * Send a new email verification notification.
     */
    public function store(Request $request): RedirectResponse
    {
        if ($request->user('web')->hasVerifiedEmail()) {
            return redirect()->intended(route('home', absolute: false));
        }

        $request->user('web')->sendEmailVerificationNotification();

        return back()->with('status', 'verification-link-sent');
    }
}
