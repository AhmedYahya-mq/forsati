<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Resources\ScholarshipResource;
use App\Models\DegreeLevel;
use App\Models\Scholarship;
use App\Models\Specialization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ScholarshipController extends Controller
{

    public function index(Request $request)
    {
        // جلب شروط البحث (id، name، email، text)
        $searchQuery = $request->query('search');

        // جلب المستخدمين مع الصلاحيات والبحث بناءً على الفلترة والبحث
        $scholarships = $this->getFilteredScholarships($request, $searchQuery);
        // إذا كان الطلب من الواجهة العادية
        return $this->returnViewResponse($scholarships,
            [
                'fundingTypes' =>  $request->input('funding_types', []), // تحويل المصفوفة إلى سلسلة
                'degreeLevelIds' => $request->input('degree_levels', []),
                'countryIds' => $request->input('country', []),
                'specializationIds' => $request->input('specialization', [])
            ]
        , $searchQuery);
    }

    public function getScholarships(Request $request)
    {
        $searchQuery = $request->query('search');
        $scholarships = $this->getFilteredScholarships($request,$searchQuery);
        return $this->returnJsonResponse($scholarships);
    }

    private function returnJsonResponse($scholarships)
    {

        // إرجاع استجابة JSON للبيانات مع معلومات الصفحات
        return ScholarshipResource::collection($scholarships)->additional([
            'meta' => [
                'links' => $scholarships->onEachSide(0)->url(1),
                'previous_page' => $scholarships->previousPageUrl(),
                'next_page' => $scholarships->nextPageUrl(),
                'total' => $scholarships->total(),
            ]
        ]);
    }

    private function returnViewResponse($scholarships,$filters , $search)
    {
        $topFiveScholarships = Scholarship::orderBy('visit', 'desc')->take(5)->get();
        $locale=\Illuminate\Support\Facades\App::getLocale();
        $topFiveBlogs = \App\Models\Blog::inRandomOrder()->take(5)->get();
        // إرجاع العرض العادي مع البيانات والصلاحيات
        return view('customer.awards', [
            'scholarships' => ScholarshipResource::collection($scholarships),
            'user' => Auth::user(),
            'search' => $search ?? "",
            "countries" => json_decode(file_get_contents(storage_path('app/countries.json'))),
            "specializations" => Specialization::all(),
            "degree_levels" => DegreeLevel::all(),
            'filters'=>$filters,
            'locale'=> $locale,
            "topFiveScholarships"=> $topFiveScholarships,
            "topFiveBlogs"=> $topFiveBlogs,
        ]);
    }
    private function getFilteredScholarships(Request $request, $searchQuery = null)
    {
        $filters = [
            'fundingTypes' => implode(',', $request->input('funding_types', [])), // تحويل المصفوفة إلى سلسلة
            'degree_levels' => implode(',', $request->input('degree_levels', [])),
            'countryIds' => implode(',', $request->input('country', [])),
            'specializationIds' => implode(',', $request->input('specialization', []))
        ];
        // استدعاء الدالة من النموذج مع تمرير المعلمات والفلاتر
        $paginatedScholarships = Scholarship::getFilteredScholarships(
            $searchQuery ?? '',
            $filters['fundingTypes'],
            $filters['countryIds'],
            $filters['specializationIds'],
            $filters['degree_levels'],
            self::perPage,
            $request->input('page', 1)
        );
        return $paginatedScholarships;
    }

    public function show($slug)
    {
        $scholarship = Scholarship::where("slug_en", $slug)->orWhere("slug_ar", $slug)->firstOrFail();

        $relatedScholarships = $this->getRelatedScholarship($this->locale, $scholarship);
        $topFiveScholarships = Scholarship::where('id', '!=', $scholarship->id)->orderBy('visit', 'desc')->take(5)->get();
        $topFiveBlogs = \App\Models\Blog::inRandomOrder()->take(5)->get();
        return view('customer.award-details', [
            'user' => auth()->guard('web')->user() ?? null,
            'scholarship' => $scholarship,
            'relatedScholarships' => $relatedScholarships,
            'locale' => $this->locale,
            "topFiveBlogs"=> $topFiveBlogs,
            "topFiveScholarships"=> $topFiveScholarships,
        ]);
    }

    private function getRelatedScholarship($locale, $scholarship)
{
    $degreeLevels = $scholarship->degree_levels->pluck('name_en')->implode(',');
    $countries = $scholarship->country->pluck('name_en')->implode(',');
    $specializations = $scholarship->specializations->pluck('name_en')->implode(',');

    // إعداد الفلاتر بناءً على الأسماء المسترجعة
    $filters = [
        'fundingTypes' => implode(',', [$scholarship->funding_type ]?? []),
        'degree_levels' => $degreeLevels,  // تم استخدام الأسماء
        'countryIds' => $countries,         // تم استخدام الأسماء
        'specializationIds' => $specializations // تم استخدام الأسماء
    ];

    // محاولة جلب المنح الدراسية ذات الصلة بناءً على الفلاتر
    $relatedScholarships = Scholarship::getFilteredScholarships(
        '',
        $filters['fundingTypes'],
        $filters['countryIds'],
        $filters['specializationIds'],
        $filters['degree_levels'],
        4,
        1 ,
        true
    );

    // إذا لم يوجد أي نتائج، يتم جلب 4 عناصر بشكل عشوائي
    if ($relatedScholarships->isEmpty()) {
        $relatedScholarships = Scholarship::inRandomOrder()->take(4)->get();
    }

    return $relatedScholarships;
}

}
