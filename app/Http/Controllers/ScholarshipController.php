<?php

namespace App\Http\Controllers;

use App\FundingType;
use App\Http\Resources\ScholarshipResource;
use App\Models\Country;
use App\Models\DegreeLevel;
use App\Models\Scholarship;
use App\Models\Specialization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;



class ScholarshipController extends Controller
{
    protected $dirImage = 'scholarship/';

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
        // إرجاع العرض العادي مع البيانات والصلاحيات
        return view('admin.awards', [
            'scholarships' => ScholarshipResource::collection($scholarships),
            'user' => Auth::guard('admin')->user(),
            'search' => $search ?? "",
            "countries" => json_decode(file_get_contents(storage_path('app/countries.json'))),
            "specializations" => Specialization::all(),
            "degree_levels" => DegreeLevel::all(),
            'permission_types' => $this->getPermissions(),
            'filters'=>$filters
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

    public function edit($id){
        $scholarship=Scholarship::findOrFail($id);
        return new ScholarshipResource($scholarship);
    }

    private function validateData(Request $request, $required = "required")
    {
        // قواعد التحقق
        $rules = [
            "title_ar" => "{$required}|string|max:255",
            "title_en" => "{$required}|string|max:255",
            "description_ar" => "{$required}|string",
            "description_en" => "{$required}|string",
            "content_ar" => "{$required}|string",
            "content_en" => "{$required}|string",
            "countery" => "{$required}|exists:countries,_id",
            "specializations" => "{$required}|array",
            "specializations.*" => "exists:specializations,id",
            "degree_levels" => "{$required}|array",
            "degree_levels.*" => "exists:degree_levels,id",
            "deadline" => "{$required}|date",
            "funding_type" => "{$required}|in:" . implode(',', array_column(FundingType::cases(), 'value')),
            "image" => "{$required}"
        ];

        // رسائل التحقق المخصصة
        $messages = [
            // Arabic Titles and Content
            "title_ar.required" => "العنوان العربي مطلوب.",
            "title_ar.string" => "العنوان العربي يجب أن يكون نصًا.",
            "title_ar.max" => "العنوان العربي يجب ألا يتجاوز 255 حرفًا.",
            "description_ar.required" => "الوصف العربي مطلوب.",
            "description_ar.string" => "الوصف العربي يجب أن يكون نصًا.",
            "content_ar.required" => "المحتوى العربي مطلوب.",
            "content_ar.string" => "المحتوى العربي يجب أن يكون نصًا.",
            // English Titles and Content
            "title_en.required" => "العنوان الإنجليزي مطلوب.",
            "title_en.string" => "العنوان الإنجليزي يجب أن يكون نصًا.",
            "title_en.max" => "العنوان الإنجليزي يجب ألا يتجاوز 255 حرفًا.",
            "description_en.required" => "الوصف الإنجليزي مطلوب.",
            "description_en.string" => "الوصف الإنجليزي يجب أن يكون نصًا.",
            "content_en.required" => "المحتوى الإنجليزي مطلوب.",
            "content_en.string" => "المحتوى الإنجليزي يجب أن يكون نصًا.",
            // Country
            "countery.required" => "الدولة مطلوبة.",
            "countery.exists" => "الدولة المحددة غير موجودة.",
            // Specializations
            "specializations.required" => "التخصصات مطلوبة.",
            "specializations.array" => "التخصصات يجب أن تكون مصفوفة.",
            "specializations.*.exists" => "التخصص المحدد غير موجود.",
            // Degree Levels
            "degree_levels.required" => "مستويات الدرجة مطلوبة.",
            "degree_levels.array" => "مستويات الدرجة يجب أن تكون مصفوفة.",
            "degree_levels.*.exists" => "مستوى الدرجة المحدد غير موجود.",
            // Deadline
            "deadline.required" => "تاريخ نهاية التقديم مطلوب.",
            "deadline.date" => "تاريخ نهاية التقديم يجب أن يكون تاريخًا صالحًا.",
            // Funding
            "funding_type.required" => "نوع التمويل مطلوب.",
            "funding_type.in" => "نوع التمويل المحدد غير صالح.",
            // Image
            "image.required" => "الصورة مطلوبة.",
        ];

        // تنفيذ التحقق
        $request->validate($rules, $messages);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // التحقق من صحة البيانات
        $this->validateData($request);

        // معالجة الصورة المخصصة
        $image = null;
        if ($request->input('image')) {
            $image = $this->hndlerImage(newImagePath: $request->input('image'));
        }
        $slug_ar=$this->makeSlug($request->title_ar);
        $slug_en=$this->makeSlug($request->title_en);
        // إنشاء المنحة
        $scholarship = Scholarship::create([
            "title_ar" => $request->title_ar,
            "title_en" => $request->title_en,
            "slug_ar" => $slug_ar,
            "slug_en" => $slug_en,
            "description_ar" => $request->description_ar,
            "description_en" => $request->description_en,
            'content_ar' => $request->content_ar,
            'content_en' => $request->content_en,
            "country_id"=>"$request->countery",
            "deadline"=> $request->deadline,
            "funding_type"=>$request->funding_type,
            "image" => $image,
            "admin_id" => Auth::guard('admin')->user()->id,
        ]);
        $scholarship->country()->associate("$request->countery");
        $scholarship->specializations()->sync($request->specializations);
        $scholarship->degree_levels()->sync($request->degree_levels);
        // استجابة الـ API
        return response()->json([
            "scholarship" => new ScholarshipResource($scholarship),
            "message" => "تم إنشاء المنحة بنجاح"
        ], 201);
    }


    private function updateScholarshipData(Request $request, Scholarship $scholarship): bool
    {
        // الحقول النصية التي يجب تحديثها
        $textFields = ['title_ar', 'title_en', 'description_ar', 'description_en', 'content_ar', 'content_en','funding_type','deadline'];

        // الحقول التي تتطلب ملفات
        $fileFields = ['image'];
        $dateFields=["deadline"];
        // العلاقات المرتبطة
        $relationFields = [
            'specializations' => 'specialization_id',
            'degree_levels' => 'degree_level_id'
        ];
        $update=false;
        if($request->has("countery") && $request->countery!= $scholarship->country_id)
        {
            $scholarship->country_id=$request->countery;
            $scholarship->country()->associate($request->countery);
            $update=true;
        }
        return $this->updateModelData(request: $request, model: $scholarship, textFields: $textFields, fileFields: $fileFields,dateFields: $dateFields, relationFields: $relationFields,updated: $update) ;
    }


    public function update(Request $request, string $id)
    {
        $this->validateData($request, "sometimes|nullable");

        $scholarship = Scholarship::findOrFail($id);
        $updated = $this->updateScholarshipData($request, $scholarship);
        if (!$updated) {
            return response()->json([
                'message' => 'لا يوجد اي تغيير',
                'Scholarship' =>  new ScholarshipResource($scholarship),
            ], 400);
        }


        return response()->json([
            'message' => 'تم تعديل بيانات المستخدم',
            'Scholarship' => new ScholarshipResource($scholarship),
        ], 200);
    }

    public function destroy(string $id)
    {
        $scholarship = Scholarship::findOrFail($id);
        $scholarship->delete();

        return response()->json(['message' => 'تم حذف المنحة بنجاح']);
    }
}
