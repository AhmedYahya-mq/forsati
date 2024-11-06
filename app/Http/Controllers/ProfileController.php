<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    protected $dirImage = 'users/';
    /**
     * يعرض نموذج تعديل الملف الشخصي للمستخدم.
     *
     * هذه الدالة تسترجع بيانات المستخدم المُصَدَقَّة وتمررها إلى واجهة 'profile.edit'.
     *
     * @param Request $request يحتوي الطلب الوارد على كائن الطلب المُرسَل حيث يحتوي على المستخدم المُصَدَقَّ.
     *
     * @return View يُرجع كائن العرض مع واجهة 'profile.edit' وبيانات المستخدم المُصَدَقَّ.
     */
    public function edit(Request $request): View
    {
        if (Gate::denies('view', [$request->user('admin'), \App\Models\Admin::class])) {
            // إذا تم رفض الصلاحية، قم بعرض صفحة 404
            abort(404);
        }

        return view('profile.edit', [
            'user' => $request->user('admin'),
            'permission_types' => $this->getPermissions(),
        ]);
    }

    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        Gate::authorize('update', [$request->user('admin'),\App\Models\Admin::class]);
        // تحديث البيانات الأخرى
        $request->user('admin')->fill($request->validated());
        // إذا كانت الصورة الجديدة موجودة في الطلب
        if ($request->input('image')) {
            $finalPath=$this->hndlerImage($request->input('image'),$request->user('admin')->image,true);
            $request->user('admin')->image =$finalPath; // أو أي اسم ترغب به
        }

        // إعادة تعيين التحقق من البريد الإلكتروني إذا تم تعديله
        if ($request->user('admin')->isDirty('email')) {
            $request->user('admin')->email_verified_at = null;
        }

        // حفظ البيانات
        $request->user('admin')->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }


    /**
     * حذف حساب المستخدم.
     *
     * تعالى هذه الدالة تتعامل مع حذف حساب المستخدم. تتحقق من كلمة المرور الخاصة بالمستخدم،
     * تسجيل خروج المستخدم، حذف سجل المستخدم من قاعدة البيانات، إلغاء صلاحية جلسة المستخدم،
     * وإعادة توجيه المستخدم إلى الصفحة الرئيسية.
     *
     * @param Request $request الطلب الوارد يحتوي على كلمة المرور الخاصة بالمستخدم.
     *
     * @return RedirectResponse إعادة توجيه إلى الصفحة الرئيسية.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Gate::authorize('delete', $request->user('admin'));
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user('admin');

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
