<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;
use App\Http\Resources\BlogResource;
use Illuminate\Support\Facades\Auth;

class BlogController extends Controller
{
    protected $dirImage = 'blog/';
    public function index(Request $request)
    {
        // جلب شروط البحث (id، name، email، text)
        $searchQuery = $request->query('search');

        // جلب المستخدمين مع الصلاحيات والبحث بناءً على الفلترة والبحث
        $Blogs = $this->getFilteredBlogs( $searchQuery);

        // إذا كان الطلب من الواجهة العادية
        return $this->returnViewResponse($Blogs, $searchQuery);
    }

    public function getBlogs(Request $request){
        $searchQuery = $request->query('search');

        $Blogs = $this->getFilteredBlogs($searchQuery);
        return $this->returnJsonResponse($Blogs);

    }

    private function returnJsonResponse($Blog)
    {
        // إرجاع استجابة JSON للبيانات مع معلومات الصفحات
        return BlogResource::collection($Blog)->additional([
            'meta' => [
                'links' => $Blog->onEachSide(0)->url(1),
                'previous_page' => $Blog->previousPageUrl(),
                'next_page' => $Blog->nextPageUrl(),
                'total' => $Blog->total(),
            ]
        ]);
    }

    private function returnViewResponse($Blogs, $search)
    {
        // إرجاع العرض العادي مع البيانات والصلاحيات
        return view('admin.blogs', [
            'blogs' => BlogResource::collection($Blogs),
            'user' => Auth::guard('admin')->user(),
            'search' => $search ?? "",
            'permission_types' => $this->getPermissions(),
        ]);
    }

    private function getFilteredBlogs( $searchQuery = null)
    {
        $query = Blog::query(); // استخدام query بدلاً من all

        // إضافة شروط البحث (إذا كانت موجودة)
        if (!empty($searchQuery)) {
            $query->where(function ($q) use ($searchQuery) {
                $q->where('id', $searchQuery)
                    ->orWhere('title_ar', 'like', "%$searchQuery%")
                    ->orWhere('title_en', 'like', "%$searchQuery%")
                    ->orWhere('description_ar', 'like', "%$searchQuery%")
                    ->orWhere('description_en', 'like', "%$searchQuery%");
            });
        }

        // استرجاع البيانات مع pagination
        return $query->paginate(self::perPage);
    }
    
    private function validateData(Request $request, $required = "required")
    {
        // قواعد التحقق
        $rules = [
            "title_ar"=>"{$required}|string|max:255",
            "title_en" =>"{$required}|string|max:255",
            "description_ar"=>"{$required}|string",
            "description_en"=>"{$required}|string",
            "content_ar"=>"{$required}|string",
            "content_en"=>"{$required}|string",
            "image"=>"{$required}"
        ];
        // رسائل التحقق المخصصة
        $messages = [
            // title_ar
            "title_ar.required" => "العنوان العربي مطلوب",
            "title_ar.string" => "العنوان العربي يجب أن يكون نصا",
            "title_ar.max" => "العنوان العربي يجب أن يكون قصيراً إلى 255 حرفاً",
            // title_en
            "title_en.required" => "العنوان الإنجليزي مطلوب",
            "title_en.string" => "العنوان الإنجليزي يجب أن يكون نصا",
            "title_en.max" => "العنوان الإنجليزي يجب أن يكون قصيراً إلى 255 حرفاً",
            // description_ar
            "description_ar.required" => "الوصف العربي مطلوب",
            "description_ar.string" => "الوصف العربي يجب أن يكون نصا",
            // description_en
            "description_en.required" => "الوصف الإنجليزي مطلوب",
            "description_en.string" => "الوصف الإنجليزي يجب أن يكون نصا",
            // content_ar
            "content_ar.required" => "المحتوى العربي مطلوب",
            "content_ar.string" => "المحتوى العربي يجب أن يكون نصا",
            // content_en
            "content_en.required" => "المحتوى الإنجليزي مطلوب",
            "content_en.string" => "المحتوى الإنجليزي يجب أن يكون نصا",
            // image
            "image.required" => "الصورة مطلوبة",
            "image.string" => "الصورة يجب أن تكون مسار صحيح",

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
            $image = $this->hndlerImage($request->input('image'));
        }

        $slug_ar=$this->makeSlug($request->title_ar);
        $slug_en=$this->makeSlug($request->title_en);

        // إنشاء المدونة
        $blog = Blog::create([
            "title_ar" => $request->title_ar,
            "title_en" => $request->title_en,
            "slug_ar" => $slug_ar,
            "slug_en" => $slug_en,
            "description_ar" => $request->description_ar,
            "description_en" => $request->description_en,
            'content_ar' => $request->content_ar,
            'content_en' => $request->content_en,
            "image" => $image,
            "admin_id" => Auth::guard('admin')->user()->id,  // إضافة admin_id هنا
        ]);

        // استجابة الـ API
        return response()->json([
            "blog" => new BlogResource($blog),
            "message" => "تم إنشاء المدونة بنجاح"
        ], 201);
    }

    public function edit($id){
        $blog=Blog::findOrFail($id);
        return new BlogResource($blog);
    }


    private function updateBlogData(Request $request, Blog $blog): bool
    {
        // الحقول النصية التي يجب تحديثها
        $textFields = ['title_ar', 'title_en', 'description_ar', 'description_en', 'content_ar', 'content_en'];

        // الحقول التي تتطلب ملفات
        $fileFields = ['image'];
        return $this->updateModelData(request: $request, model: $blog, textFields: $textFields, fileFields: $fileFields) ;
    }


    public function update(Request $request, string $id)
    {
        $this->validateData($request, "sometimes|nullable");

        $blog = Blog::findOrFail($id);

        $updated = $this->updateBlogData($request, $blog);
        if (!$updated) {
            return response()->json([
                'message' => 'لا يوجد اي تغيير',
                'data' => $request->all(),
            ], 400);
        }


        return response()->json([
            'message' => 'تم تعديل بيانات المستخدم',
            'blog' => new BlogResource($blog),
        ], 200);
    }

    public function destroy(string $id)
    {
        $blog = Blog::findOrFail($id);
        $blog->delete();

        return response()->json(['message' => 'تم حذف المدونة بنجاح']);
    }
}
