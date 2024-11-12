<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class PoliciesDashboardMidleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $admin = Auth::guard('admin')->user();
        // تحقق من صلاحيات المستخدم
        if ($admin->is_admin) {

            // الصلاحيات المتعلقة بالمستخدمين
            if (Gate::forUser($admin)->allows('checkPolicy', \App\Models\Admin::class)) {
                return $next($request);
            }

            // الصلاحيات المتعلقة بالإعلانات
            if (Gate::forUser($admin)->allows('checkPolicy', new \App\Models\Advertisement())) {
                return redirect()->route('admin.contentmanager')
                    ->with('error', 'You do not have the necessary permissions to access this page.');
            }

            // الصلاحيات المتعلقة بالمدونات
            if (Gate::forUser($admin)->allows('checkPolicy', new \App\Models\Blog())) {
                return redirect()->route('admin.blogsManager')
                    ->with('error', 'You do not have the necessary permissions to access this page.');
            }

            // الصلاحيات المتعلقة بالمنح الدراسية
            if (Gate::forUser($admin)->allows('checkPolicy', new \App\Models\Scholarship())) {
                return redirect()->route('admin.awardsManager')
                    ->with('error', 'You do not have the necessary permissions to access this page.');
            }

            // الصلاحيات المتعلقة بالتخصصات
            if (Gate::forUser($admin)->allows('checkPolicy', new \App\Models\Specialization())) {
                return redirect()->route('admin.specializationManager')
                    ->with('error', 'You do not have the necessary permissions to access this page.');
            }
        }

        // إذا لم تتوفر الصلاحيات
        abort(401);
    }
}
