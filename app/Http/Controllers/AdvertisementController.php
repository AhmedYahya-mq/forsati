<?php

namespace App\Http\Controllers;

use App\Http\Resources\AdvertisementResource;
use App\Models\Advertisement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdvertisementController extends Controller
{
    protected $dirImage = 'advertisement/';
    protected $fileKeys = ['desktop_image', 'mobile_image'];


    public function index(Request $request)
    {
        // جلب الصلاحية من الطلب (إذا كانت موجودة)
        $filterPermission = $request->query('stateAd');

        // جلب شروط البحث (id، name، email، text)
        $searchQuery = $request->query('search');

        // جلب المستخدمين مع الصلاحيات والبحث بناءً على الفلترة والبحث
        $advertisements = $this->getFilteredAdvertisement($filterPermission, $searchQuery);

        // إذا كان الطلب من الواجهة العادية
        return $this->returnViewResponse($advertisements, $filterPermission,$searchQuery);
    }

    public function getAdvertisements(Request $request){
        $filterStateAd = $request->query('stateAd');
        $searchQuery = $request->query('search');

        $advertisements = $this->getFilteredAdvertisement($filterStateAd, $searchQuery);
        return $this->returnJsonResponse($advertisements);

    }

    private function getFilteredAdvertisement($filterSateAd, $searchQuery = null)
    {
    // بناء الاستعلام الأساسي لجلب المستخدمين مع الصلاحيات
        $query = Advertisement::query();

        // إضافة فلترة الصلاحيات
        if (!empty($filterSateAd) && $filterSateAd != "__ALL__" && in_array($filterSateAd,["__ACTIVE__","__UNACTIVE__"])) {
                $query->where('isActivate',"=", $filterSateAd== "__ACTIVE__"?true:false);
        }

        // إضافة شروط البحث (إذا كانت موجودة)
        if (!empty($searchQuery)) {
            $query->where(function ( $q) use ($searchQuery) {
                $q->where('id', $searchQuery)
                    ->orWhere('title', 'like', "%$searchQuery%")
                    ->orWhere('url', 'like', "%$searchQuery%");
            });
        }

        // استرجاع البيانات مع pagination
        return $query->paginate(self::perPage);
    }

    private function returnJsonResponse($advertisements)
    {
        // إرجاع استجابة JSON للبيانات مع معلومات الصفحات
        return AdvertisementResource::collection($advertisements)->additional([
            'meta' => [
                'links' => $advertisements->onEachSide(0)->url(1),
                'previous_page' => $advertisements->previousPageUrl(),
                'next_page' => $advertisements->nextPageUrl(),
                'total' => $advertisements->total(),
            ]
        ]);
    }

    private function returnViewResponse($advertisements, $filterSateAd, $search)
    {
        // إرجاع العرض العادي مع البيانات والصلاحيات
        return view('admin.contentmanager', [
            'advertisements' => AdvertisementResource::collection($advertisements),
            'user' => Auth::guard('admin')->user(),
            'stateAd' => $filterSateAd ?? "__ALL__",
            'search' => $search ?? "",
            'permission_types' => $this->getPermissions(),
        ]);
    }


    private function validateData(Request $request, $required = "required")
    {
        // قواعد التحقق
        $rules = [
            "title" => "{$required}|string|max:255",
            "url" => "{$required}|url",
            "start_date" => "{$required}|date",
            "end_date" => "{$required}|date",
            "mobile_image" => "{$required}",
            "desktop_image" => "{$required}"
        ];

        // رسائل التحقق المخصصة
        $messages = [
            // title
            "title.required" => 'حقل العنوان مطلوب.',
            "title.string" => 'يجب أن يكون العنوان نصًا.',
            "title.max" => 'يجب ألا يتجاوز العنوان 255 حرفًا.',

            // url
            "url.required" => 'حقل URL مطلوب.',
            "url.url" => 'يجب أن يكون الحقل رابط URL صالح.',

            // startDate
            "start_date.required" => 'حقل تاريخ البدء مطلوب.',
            "start_date.date" => 'يجب أن يكون تاريخ البدء صالح.',

            // endDate
            "end_date.required" => 'حقل تاريخ الانتهاء مطلوب.',
            "end_date.date" => 'يجب أن يكون تاريخ الانتهاء صالح.',

            // filepond-phone
            "mobile_image.required" => 'حقل صورة الهاتف مطلوب.',
            "mobile_image.src" => 'يجب أن يكون مصدر صورة الهاتف صحيحًا.',
            "mobile_image.string" => 'يجب أن يكون مصدر صورة الهاتف نصًا.',

            // filepond-pc
            "desktop_image.required" => 'حقل صورة الكمبيوتر مطلوب.',
            "desktop_image.src" => 'يجب أن يكون مصدر صورة الكمبيوتر صحيحًا.',
            "desktop_image.string" => 'يجب أن يكون مصدر صورة الكمبيوتر نصًا.'
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

        // معالجة الصورة المخصصة للهاتف
        $filepond_phone = null;
        if ($request->input('mobile_image')) {
            $filepond_phone = $this->hndlerImage($request->input('mobile_image'));
        }

        // معالجة الصورة المخصصة للكمبيوتر
        $filepond_pc = null;
        if ($request->input('desktop_image')) {
            $filepond_pc = $this->hndlerImage($request->input('desktop_image'));
        }

        // إنشاء الإعلان
        $advertisement = Advertisement::create([
            "title" => $request->title,
            "url" => $request->url,
            "mobile_image" => $filepond_phone,
            "desktop_image" => $filepond_pc,
            "start_date" => $request->startDate,
            "end_date" => $request->endDate,
        ]);

        // استجابة الـ API
        return response()->json([
            "advertisement" => new AdvertisementResource($advertisement),
            "message" => "تم إنشاء الإعلان بنجاح"
        ], 201);
    }

    public function updateAdvertisementStatus(string $id)
    {
        // العثور على المستخدم أو إرجاع 404 إذا لم يتم العثور عليه
        $advertisement = Advertisement::findOrFail($id);

        // عكس حالة المستخدم (تبديل بين true/false)
        $advertisement->isActivate = !$advertisement->isActivate;

        // حفظ التغييرات
        $advertisement->save();

        // إرجاع استجابة JSON تحتوي على الحالة الجديدة للمستخدم
        return response()->json([
            'isActivate' => $advertisement->isActivate,
            'message' => 'تم تحديث نشاط الأعلان',
            'user' => $advertisement
        ],201);
    }

    public function edit($id){
        $advertisement=Advertisement::findOrFail($id);
        return new AdvertisementResource($advertisement);
    }


    private function updateAdvertisementData(Request $request, Advertisement $advertisement): bool
    {
        // الحقول النصية التي يجب تحديثها
        $textFields = ['title', 'url', 'password'];
        $fileFields=['desktop_image','mobile_image'];
        $dateFields=['start_date','end_date'];
        return $this->updateModelData(request: $request, model: $advertisement, textFields: $textFields,fileFields: $fileFields, dateFields: $dateFields) ;
    }

    public function update(Request $request, string $id)
    {
        $this->validateData($request, "sometimes|nullable");

        $advertisement = Advertisement::findOrFail($id);
        $updated = $this->updateAdvertisementData($request, $advertisement);
        if (!$updated) {
            return response()->json([
                'message' => 'لا يوجد اي تغيير',
                'data' => $request->all(),
            ], 400);
        }


        return response()->json([
            'message' => 'تم تعديل بيانات الأعلان',
            'advertisement' => new AdvertisementResource($advertisement),
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $advertisement = Advertisement::findOrFail($id);
        $advertisement->delete();

        return response()->json([
            'message' => "تم حذف الأعلان بنجاح"
        ], 200);
    }
}
