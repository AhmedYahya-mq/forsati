<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthUserMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // التحقق إذا كان المستخدم مسجلاً الدخول باستخدام الحارس 'web'
        if (!Auth::guard('web')->check()) {
            // إذا كان الطلب API، أعد استجابة JSON بدلاً من إعادة التوجيه
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Unauthorized. Please log in to access this resource.',
                ], 401); // 401 Unauthorized
            }

            // إذا لم يكن الطلب API، قم بإعادة توجيهه إلى صفحة تسجيل الدخول الخاصة بالمستخدم
            return redirect()->route('user.login');
        }

        // إذا كان المستخدم مسجلاً الدخول، السماح له بمتابعة الطلب
        return $next($request);
    }
}
