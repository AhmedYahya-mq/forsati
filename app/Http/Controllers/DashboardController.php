<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Scholarship;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $countMembers = \App\Models\Admin::query()
        ->where('is_admin', false)
        ->count();
        $countBlogs= Blog::count();
        $countScholarships = Scholarship::count();
        $topScholarships = Scholarship::orderByDesc('visit') // ترتيب النتائج بشكل تنازلي حسب عدد الزيارات
        ->take(5) // تحديد الحد الأقصى للنتائج إلى 5
        ->get(['title_ar','visit']);
        return view('admin.dashboard',[
            'user' => Auth::guard('admin')->user(),
            'countMembers' => $countMembers,
            'countBlogs' => $countBlogs,
            'countScholarships' => $countScholarships,
            'counteAcsptants' => 0,
            'topScholarships' => $topScholarships,
            'permission_types' => $this->getPermissions(),
        ]);
    }

    public function getVisitedCountry()
    {
        $countries = \App\Models\Visit::query()
            ->with('country') // جلب بيانات الدولة المرتبطة بالزيارة
            ->groupBy('country_id')
            ->selectRaw('country_id, COUNT(*) as count')
            ->get();
        // استخدام reduce لتحويل البيانات إلى الشكل المطلوب
        $formattedCountries = $countries->reduce(function ($carry, $country) {
            // استخدام العلاقة للوصول إلى اسم الدولة
            $countryName = optional($country->country)->name_ar ?? 'Unknown'; // استخدم `optional` لتجنب الأخطاء

            // حفظ البيانات بالشكل المطلوب
            $carry['visits'][Str::lower($country->country_id)] = $country->count;
            $carry['details'][$countryName] = $country->count;
            return $carry;
        }, []);

        return response()->json($formattedCountries);
    }

}
