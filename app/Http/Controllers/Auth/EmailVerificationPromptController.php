<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EmailVerificationPromptController extends Controller
{
    /**
     * Display the email verification prompt.
     */
    public function __invoke(Request $request): RedirectResponse|View
    {
        return $request->user('web')->hasVerifiedEmail()
                    ? redirect()->intended(route('home'),)
                    : view('customer.auth.verify-email', ['user' => $request->user('web')]);
    }
}
