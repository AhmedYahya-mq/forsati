<?php

namespace App\Http\Controllers;

use App\Http\Resources\SpecializationResource;
use App\Models\Specialization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SpecializationController extends Controller
{
    public function index(Request $request)
    {
        // جلب شروط البحث (id، name، email، text)
        $searchQuery = $request->query('search');

        // جلب المستخدمين مع الصلاحيات والبحث بناءً على الفلترة والبحث
        $specializations = $this->getFilteredSpecializations( $searchQuery);

        // إذا كان الطلب من الواجهة العادية
        return $this->returnViewResponse($specializations, $searchQuery);
    }

    public function getSpecializations(Request $request){
        $searchQuery = $request->query('search');

        $specializations = $this->getFilteredSpecializations($searchQuery);
        return $this->returnJsonResponse($specializations);

    }

    private function returnJsonResponse($specialization)
    {
        // إرجاع استجابة JSON للبيانات مع معلومات الصفحات
        return SpecializationResource::collection($specialization)->additional([
            'meta' => [
                'links' => $specialization->onEachSide(0)->url(1),
                'previous_page' => $specialization->previousPageUrl(),
                'next_page' => $specialization->nextPageUrl(),
                'total' => $specialization->total(),
            ]
        ]);
    }

    private function returnViewResponse($specializations, $search)
    {
        // إرجاع العرض العادي مع البيانات والصلاحيات
        return view('admin.specializations', [
            'specializations' => SpecializationResource::collection($specializations),
            'user' => Auth::guard('admin')->user(),
            'search' => $search ?? "",
            'permission_types' => $this->getPermissions(),
        ]);
    }

    private function getFilteredSpecializations( $searchQuery = null)
    {
        $query = Specialization::query(); // استخدام query بدلاً من all

        // إضافة شروط البحث (إذا كانت موجودة)
        if (!empty($searchQuery)) {
            $query->where(function ($q) use ($searchQuery) {
                $q->where('id', $searchQuery)
                    ->orWhere('name_ar', 'like', "%$searchQuery%")
                    ->orWhere('name_en', 'like', "%$searchQuery%");
            });
        }

        // استرجاع البيانات مع pagination
        return $query->paginate(self::perPage);
    }

    private function validateData(Request $request, $required="required")  {
        $request->validate([
            "name_ar"=>"{$required}|string|max:255",
            "name_en"=>"{$required}|string|max:255",
        ],[
            "name_ar.required"=>'حقل الاسم با العربي مطلوب.',
            'name_ar.string' => 'الاسم با العربي يجب أن يكون نصًا.',
            'name_ar.max' => 'الاسم با العربي يجب ألا يتجاوز 255 حرفًا.',

            "name_en.required"=>'حقل الاسم با الانجليزي مطلوب.',
            'name_en.string' => 'الاسم با الانجليزي يجب أن يكون نصًا.',
            'name_en.max' => 'الاسم با الانجليزي يجب ألا يتجاوز 255 حرفًا.',
        ]);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $this->validateData($request);

        $specialization = Specialization::create([
            'name_ar' => $request->name_ar,
            'name_en' => $request->name_en,
        ]);

        return response()->json(["specialization"=>new SpecializationResource($specialization), "message"=>"تم نشاء التخصص بنجاح"], 201);
    }

    public function edit($id){
        $specialization=Specialization::findOrFail($id);
        return new SpecializationResource($specialization);
    }

    private function updateSpecializationData(Request $request, Specialization $specialization): bool
    {
        // الحقول النصية التي يجب تحديثها
        $textFields = ['name_ar', 'name_en'];
        return $this->updateModelData(request: $request, model: $specialization, textFields: $textFields) ;
    }


    public function update(Request $request, string $id)
    {
        $this->validateData($request, "sometimes|nullable");

        $specialization = Specialization::findOrFail($id);

        $updated = $this->updateSpecializationData($request, $specialization);
        if (!$updated) {
            return response()->json([
                'message' => 'لا يوجد اي تغيير',
                'data' => $request->all(),
            ], 400);
        }


        return response()->json([
            'message' => 'تم تعديل بيانات المستخدم',
            'specialization' => new SpecializationResource($specialization),
        ], 200);
    }

    public function destroy(string $id)
    {
        $specialization = Specialization::findOrFail($id);
        $specialization->delete();

        return response()->json(['message' => 'تم حذف التخصص بنجاح']);
    }
}
