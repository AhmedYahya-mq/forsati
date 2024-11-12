<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Laravel\Socialite\Facades\Socialite;

class SocialController extends Controller
{
    // توجيه المستخدم إلى صفحة تسجيل الدخول باستخدام جوجل
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->stateless()->setHttpClient(new \GuzzleHttp\Client(['verify' => false]))->redirect();
    }

    // معالجة الاستجابة من جوجل
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->stateless()->setHttpClient(new \GuzzleHttp\Client(['verify' => false]))->user();

            $user = User::where('email', $googleUser->getEmail())->first();

            if (!$user) {
                 $password = \Illuminate\Support\Str::random(16); // توليد كلمة مرور عشوائية مكونة من 16 حرفًا

                $user = User::create([
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'social_id' => $googleUser->getId(),
                    'social_type'=>'google',
                    'email_verified_at'=>now(),
                    'status'=>true,
                    'password' => bcrypt($password),
                ]);

                $normalUserPermissionId = "normal_user"; // استبدل 1 بمعرف الصلاحية المناسب لـ normal_user
                // إضافة الصلاحية إلى المستخدم
                $user->permissions()->attach($normalUserPermissionId);
                // Save user details
                $user->detailsUser()->create([
                    'notification' => [
                        "ad" => true,
                        "scholarship" => true,
                        "blog" => true,
                    ],
                ]);

                $imageUrl = $googleUser->getAvatar();
                $imageName = basename($imageUrl);
                $imageContents = file_get_contents($imageUrl);
                $imagePath = 'upload/images/users/' . $imageName.".png";
                // حفظ الصورة في مجلد storage
                Storage::disk('public')->put($imagePath, $imageContents);
                // تخزين رابط الصورة في قاعدة البيانات
                $user->update(['image' =>  $imagePath]);
            }


            // تسجيل دخول المستخدم
            Auth::guard('web')->login($user);

            return redirect()->route('home');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors('socialError', 'حدث خطأ ما أثناء تسجيل الدخول أو إنشاء الحساب باستخدام جوجل.');
        }
    }
}
