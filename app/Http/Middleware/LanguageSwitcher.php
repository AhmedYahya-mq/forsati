<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cookie;

class LanguageSwitcher
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // جلب قيمة الكوكي "locale" أو تعيين اللغة الافتراضية
        $locale = Cookie::get('locale', config('app.locale'));
        // ضبط اللغة للتطبيق
        App::setLocale($locale);

        // متابعة الطلب
        return $next($request);
    }
}
