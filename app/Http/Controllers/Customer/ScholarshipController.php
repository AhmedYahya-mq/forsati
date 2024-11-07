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
        $locale=\Illuminate\Support\Facades\App::getLocale();
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
}
