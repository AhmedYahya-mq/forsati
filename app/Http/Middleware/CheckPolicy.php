<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class CheckPolicy
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $policy
     * @param  string  $model
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next, $policy, $model)
    {
        // الحصول على المستخدم
        $admin = auth('admin')->user();

        // إذا لم يكن المستخدم مسجل الدخول، إعادة التوجيه
        if (!$admin) {
            return redirect()->route('admin.login');
        }

        // التحقق من صلاحية الـ policy للمستخدم
        if (Gate::forUser($admin)->allows($policy, $model)) {
            return $next($request);
        }
        abort(403);
    }
}

