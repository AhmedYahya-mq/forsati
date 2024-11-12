<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {
            // تخصيص إعادة التوجيه لكل حارس (guard)
            if ($guard === 'admin') {
                return redirect()->route('dashboard');
            } else {
                return redirect()->back()->with('fallback', route('home'));
            }
        }

        return $next($request);
    }
}
