<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $guard = "web"): Response
    {
        // التحقق إذا كان المستخدم مسجلاً الدخول باستخدام الحارس 'web'
        if (!Auth::guard($guard)->check()) {
            // إذا كان الطلب API، أعد استجابة JSON بدلاً من إعادة التوجيه
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Unauthorized. Please log in to access this resource.',
                ], 401); // 401 Unauthorized
            }

            if($guard==="admin")
                return redirect()->route('admin.login');
            else
                return redirect()->route('login');
        }

        // إذا كان المستخدم مسجلاً الدخول، السماح له بمتابعة الطلب
        return $next($request);
    }
}
