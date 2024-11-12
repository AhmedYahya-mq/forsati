<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $align=App::getLocale() !=="en"?"right":"left";
        $dir=App::getLocale() !=="en"?"rtl":"ltr";
        $user=User::with('detailsUser')->find(auth('web')->id());

        return view("customer.profile.index",[
            "align"=>$align,
            "dir"=>$dir,
            "locale"=>App::getLocale(),
            "user"=>$user,
            "countries" => json_decode(file_get_contents(storage_path('app/countries.json'))),
        ]);
    }


    private function updateUserData(Request $request, User $user): bool
    {
        // الحقول النصية التي يجب تحديثها
        $textFields = ['name', 'email'];

        // الحقول التي تتطلب ملفات
        $fileFields = ['image'];
        $update=false;
        return $this->updateModelData(request: $request, model: $user, textFields: $textFields, fileFields: $fileFields,updated: $update) ;
    }


    private function updateDetailData(Request $request, User $user): bool
    {
        // الحقول النصية التي يجب تحديثها
        $textFields = ['bio', 'gender','phone'];

        $dateFields=["birthday"];

        $update=false;
        if($request->has("country") && $request->country !== $user->country_id)
        {
            $user->country_id=$request->country;
            $user->country()->associate($request->country);
            $user->save();
            $update=true;
        }
        return $this->updateModelData(request: $request, model: $user->detailsUser, textFields: $textFields,dateFields: $dateFields ,updated: $update) ;
    }


    private function updateLinkData(Request $request, User $user): bool
    {
        // الحقول النصية التي يجب تحديثها
        $textFields = ['twitter', 'facebook','google','linkedIn','instagram'];

        return $this->updateModelData(request: $request, model: $user->detailsUser, textFields: $textFields) ;
    }

    public function general(Request $request){
        $user = User::findOrFail(auth('web')->id());
        $updated = $this->updateUserData($request, $user);
        // إذا لم يتم التحديث، إظهار رسالة تحذير
        if (!$updated) {
            return redirect()->back()->withErrors(['warning.user' => 'لا يوجد أي تغيير']);
        }

        // إعادة تعيين التحقق من البريد الإلكتروني إذا تم تعديله
        if (auth('web')->user()->email !== $request->email) {
            $request->user()->email_verified_at = null;
            $request->user()->save();
        }
        // إذا تم التحديث بنجاح، إظهار رسالة نجاح
        return redirect()->back()->with('succeses.user', 'تم حفظ البيانات بنجاح');
    }

    public function updateDetail(Request $request){
        $user = User::findOrFail(auth('web')->id());
        $updated = $this->updateDetailData($request, $user);

        // إذا لم يتم التحديث، إظهار رسالة تحذير
        if (!$updated) {
            return redirect()->back()->withErrors(['info' => 'لا يوجد أي تغيير']);
        }
        // إذا تم التحديث بنجاح، إظهار رسالة نجاح
        return redirect()->back()->with('info', 'تم حفظ البيانات بنجاح');
    }


    public function updateLink(Request $request){
        $user = User::findOrFail(auth('web')->id());
        $updated = $this->updateLinkData($request, $user);
        // إذا لم يتم التحديث، إظهار رسالة تحذير
        if (!$updated) {
            return redirect()->back()->withErrors(['link' => 'لا يوجد أي تغيير']);
        }
        // إذا تم التحديث بنجاح، إظهار رسالة نجاح
        return redirect()->back()->with('link', 'تم حفظ البيانات بنجاح');
    }


    public function updateNotifications(Request $request){
        $user = User::findOrFail(auth('web')->id());

        $notifications = [
            "ad" => (bool) $request->ad,
            "scholarship" => (bool) $request->scholarships,
            "blog" => (bool) $request->news,
        ];

        if ($user->detailsUser) {
            $user->detailsUser->notification = $notifications;
            $user->detailsUser->save();
            return redirect()->back()->with('notifications', 'تم حفظ البيانات بنجاح');
        } else {
            return redirect()->back()->withErrors(['notifications' => 'لا يوجد أي تغيير']);
        }

    }


    /**
     * رفع صورة مؤقتة
     */
    public function uploadImageTemp(Request $request)
    {
        // إنشاء مجلد 'temp' إذا لم يكن موجودًا
        if (!Storage::disk('public')->exists('temp')) {
            Storage::disk('public')->makeDirectory('temp');
        }

        $key= $this->getUploadedFileKey($request);
        // التحقق من أن الطلب يحتوي على ملف
        if ($request->hasFile($key)) {
            // تحقق من صحة الملف
            $request->validate([
                $key => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:800',
            ], [
                "{$key}.required" => 'يجب رفع صورة.',
                "{$key}.image" => 'يجب أن يكون الملف المرفوع صورة.',
                "{$key}.mimes" => 'صيغة الصورة يجب أن تكون jpeg, png, jpg, gif, أو svg.',
                "{$key}.max" => 'حجم الصورة لا يجب أن يتجاوز 3 ميغابايت.',
            ]);


            // إنشاء اسم عشوائي جديد
            $newName = 'temp_' . Str::random(10) . '.' . $request->file($key)->extension();

            // حفظ الصورة
            $path = $request->file($key)->storeAs('temp', $newName, 'public');

            return response()->json(['path' => $path, "message" => "تم رفع الصورة بنجاح"], 200);
        }

        return response()->json(['message' => 'لم يتم رفع الصورة'], 400);
    }

    /**
     * حذف صورة مؤقتة
     */
    public function deleteTempImage(Request $request)
    {
        // جلب المسار من الطلب
        $tempPath = $request->input("path");

        // تحقق من أن المسار موجود
        if (!$tempPath) {
            return response()->json(['message' => 'لا يوجد ملف صوره على السيرفر'], 400);
        }

        // تحقق من أن الملف موجود في التخزين
        if (Storage::disk('public')->exists($tempPath)) {
            // حذف الملف
            Storage::disk('public')->delete($tempPath);
            return response()->json(['message' => 'تم حذف الصورة بنجاح'], 200);
        }

        return response()->json(['message' => 'لا توجد صورة: ' . $tempPath], 404);
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
        Gate::authorize('delete', $request->user('web'));
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user('web');

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
