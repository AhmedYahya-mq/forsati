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
            if (Gate::allows('checkPolicy', \App\Models\Admin::class) && $admin->isAdmin()) {
                return $next($request);
            }
            if (Gate::allows('checkPolicy', \App\Models\Admin::class)) {
                return redirect()->route('admin.usersManager.index')
                    ->with('error', 'You do not have the necessary permissions to access this page.');
            }

            // الصلاحيات المتعلقة بالإعلانات
            if (Gate::allows('checkPolicy', \App\Models\Advertisement::class)) {
                return redirect()->route('admin.contentmanager')
                    ->with('error', 'You do not have the necessary permissions to access this page.');
            }

            // الصلاحيات المتعلقة بالمدونات
            if (Gate::allows('checkPolicy', \App\Models\Blog::class)) {
                return redirect()->route('admin.blogsManager')
                    ->with('error', 'You do not have the necessary permissions to access this page.');
            }

            // الصلاحيات المتعلقة بالمنح الدراسية
            if (Gate::allows('checkPolicy', \App\Models\Scholarship::class)) {
                return redirect()->route('admin.awardsManager')
                    ->with('error', 'You do not have the necessary permissions to access this page.');
            }

            // الصلاحيات المتعلقة بالتخصصات
            if (Gate::allows('checkPolicy', \App\Models\Specialization::class)) {
                return redirect()->route('admin.specializationManager')
                    ->with('error', 'You do not have the necessary permissions to access this page.');
            }
        }

        // إذا لم تتوفر الصلاحيات
        abort(401);
    }
}
