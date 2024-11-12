<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Permission;
use App\Observers\AdminObserver;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{

    public function index(Request $request)
    {

        // جلب الصلاحية من الطلب (إذا كانت موجودة)
        $filterPermission = $request->query('user-type');

        // جلب شروط البحث (id، name، email، text)
        $searchQuery = $request->query('search');

        // جلب المستخدمين مع الصلاحيات والبحث بناءً على الفلترة والبحث
        $admins = $this->getFilteredAdmins($filterPermission, $searchQuery);

        // إذا كان الطلب من الواجهة العادية
        return $this->returnViewResponse($admins, $filterPermission,$searchQuery);
    }

    public function getAdmins(Request $request){
        $filterPermission = $request->query('user-type');
        $searchQuery = $request->query('search');

        $admins = $this->getFilteredAdmins($filterPermission, $searchQuery);
        return $this->returnJsonResponse($admins);

    }

    private function getFilteredAdmins($filterPermission, $searchQuery = null)
    {
    // بناء الاستعلام الأساسي لجلب المستخدمين مع الصلاحيات
    $query = Admin::with('permissions');

    // إضافة فلترة الصلاحيات
    if (!empty($filterPermission) && $filterPermission != "__ALL__") {
            $query->whereHas('permissions', function ($q) use ($filterPermission) {
                $this->applyPermissionFilter($q, $filterPermission);
            });
        }

        // إضافة شروط البحث (إذا كانت موجودة)
        if (!empty($searchQuery)) {
            $query->where(function ( $q) use ($searchQuery) {
                $q->where('id', $searchQuery)
                    ->orWhere('name', 'like', "%$searchQuery%")
                    ->orWhere('email', 'like', "%$searchQuery%")
                    // البحث في جدول permissions على العمود text
                    ->orWhereHas('permissions', function ($q) use ($searchQuery) {
                        $q->where('text', 'like', "%$searchQuery%");
                    });
            });
        }

        // استرجاع البيانات مع pagination
        return $query->paginate(self::perPage);
    }

    private function applyPermissionFilter($query, $filterPermission)
    {
        // لو كانت الصلاحية 'manage_all' أو 'normal_user'
        if ($filterPermission == 'manage_all' || $filterPermission == 'normal_user') {
            $query->where('permission_id', $filterPermission);
        } else {
            // تطبيق فلترة على الصلاحيات المعروفة
            $validPermissions = $this->getValidPermissions();
            $query->whereIn('permission_id', $validPermissions);
        }
    }

    private function getValidPermissions()
    {
        // الصلاحيات المعروفة والمسموحة
        return [
            'manage_users',
            'manage_specializations',
            'manage_scholarships',
            'manage_content',
            'manage_blogs'
        ];
    }

    private function returnJsonResponse($admins)
    {
        // إرجاع استجابة JSON للبيانات مع معلومات الصفحات
        return UserResource::collection($admins)->additional([
            'meta' => [
                'links' => $admins->onEachSide(0)->url(1),
                'previous_page' => $admins->previousPageUrl(),
                'next_page' => $admins->nextPageUrl(),
                'total' => $admins->total(),
            ]
        ]);
    }

    private function returnViewResponse($admins, $filterPermission, $search)
    {
        // إرجاع العرض العادي مع البيانات والصلاحيات
        return view('admin.usersManager', [
            'users' => $admins,
            'user' => Auth::guard('admin')->user(),
            'user_type' => $filterPermission ?? "__ALL__",
            'search' => $search ?? "",
            'permissions' => Permission::query()->whereNotIn("id",["normal_user"])->get(),
            'permission_types' => $this->getPermissions(),
        ]);
    }

    public function updateAdminStatus(string $id)
    {
        // العثور على المستخدم أو إرجاع 404 إذا لم يتم العثور عليه
        $admin = Admin::findOrFail($id);

        // عكس حالة المستخدم (تبديل بين true/false)
        $admin->status = !$admin->status;

        // حفظ التغييرات
        $admin->save();

        // إرجاع استجابة JSON تحتوي على الحالة الجديدة للمستخدم
        return response()->json([
            'status' => $admin->status,
            'message' => 'تم تحديث نشاط المستخدم',
            'user' => $admin
        ],201);
    }

    public function updateAdminEmailVerified(string $id)
    {
        // العثور على المستخدم أو إرجاع 404 إذا لم يتم العثور عليه
        $admin = Admin::findOrFail($id);

        // عكس حالة المستخدم (تبديل بين true/false)
        $admin->email_verified_at = $admin->email_verified_at===null ? now() : null;

        // حفظ التغييرات
        $admin->save();

        // إرجاع استجابة JSON تحتوي على الحالة الجديدة للمستخدم
        return response()->json([
            'email_verified_at' => $admin->email_verified_at,
            'message' => 'تم تحديث حالة البريد الكتروني',
            'user' => $admin
        ]);
    }


    private function validateStore(Request $request)  {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'permissions' => 'required|array',
            'permissions.*' => 'exists:permissions,id'
        ], [
            'name.required' => 'حقل الاسم مطلوب.',
            'name.string' => 'الاسم يجب أن يكون نصًا.',
            'name.max' => 'الاسم يجب ألا يتجاوز 255 حرفًا.',

            'email.required' => 'حقل البريد الإلكتروني مطلوب.',
            'email.email' => 'يجب إدخال بريد إلكتروني صحيح.',
            'email.max' => 'البريد الإلكتروني يجب ألا يتجاوز 255 حرفًا.',
            'email.unique' => 'هذا البريد الإلكتروني مستخدم من قبل.',

            'password.required' => 'حقل كلمة المرور مطلوب.',
            'password.string' => 'كلمة المرور يجب أن تكون نصًا.',
            'password.min' => 'كلمة المرور يجب أن تكون على الأقل 8 أحرف.',
            'password.confirmed' => 'تأكيد كلمة المرور غير متطابق.',

            'permissions.required' => 'يجب تحديد الأذونات.',
            'permissions.array' => 'الأذونات يجب أن تكون في صيغة مصفوفة.',
            'permissions.*.exists' => 'الأذونات المحددة غير موجودة في قاعدة البيانات.'
        ]);

    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validateStore($request);
        // إنشاء المستخدم الجديد
        $admin = Admin::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'is_admin' => true,
            'status' => true,
        ]);

        // ربط الصلاحيات بالمستخدم
        $admin->permissions()->attach($request->permissions);

         // Save user details
         $admin->detailsUser()->create([
            'notification' => [
                "ad" => true,
                "scholarship" => true,
                "blog" => true,
            ],
        ]);

        // إرجاع المستخدم الجديد مع حالة 201
        return response()->json(['user'=>new UserResource($admin),"message"=>"تم نشاء مستخدم بنجاح"], 201);
    }

    public function edit($id){
        $admin=Admin::findOrFail($id);
        return new UserResource($admin);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // العثور على المستخدم المحدد
        $admin = Admin::findOrFail($id);

        // التحقق من صحة البيانات المدخلة
        $this->validateRequest($request, $admin);

        // تتبع ما إذا تم تحديث البيانات
        $updated = false;
        $updatedPermissions = false;

        // تحديث صلاحيات المستخدم
        $updatedPermissions = $this->updateAdminPermissions($request, $admin);

        // تحديث بيانات المستخدم
        $updated = $this->updateAdminData($request, $admin);
        // إعادة تعيين التحقق من البريد الإلكتروني إذا تم تعديله
        if ($request->user('admin')->isDirty('email')) {
            $request->user('admin')->email_verified_at = null;
        }

        // تسجيل الحدث إذا تم تحديث أي شيء
        if (!$updated and $updatedPermissions) {
            $this->logAdminUpdate($admin, $updatedPermissions);
        }

        // إذا لم يتم تحديث أي شيء، إرجاع رسالة مناسبة
        if (!$updated && !$updatedPermissions) {
            return response()->json([
                'message' => 'لا يوجد اي تغيير',
                'data' => $request->all(),
            ], 200);
        }

        // إرجاع البيانات المحدثة
        return response()->json([
            'message' => 'تم تعديل بيانات المستخدم',
            'user' => new UserResource($admin),
        ], 200);
    }

    private function validateRequest(Request $request, Admin $admin)
    {
        $request->validate([
            'name' => 'sometimes|nullable|string|max:255',
            'email' => 'sometimes|nullable|string|email|max:255|unique:users,email,' . $admin->id,
            'password' => 'sometimes|nullable|string|min:8|confirmed',
            'permissions' => 'sometimes|nullable|array',
            'permissions.*' => 'exists:permissions,id',
        ]);
    }

    private function updateAdminData(Request $request, Admin $admin): bool
    {
        // الحقول النصية التي يجب تحديثها
        $textFields = ['name', 'email', 'password'];
        return $this->updateModelData(request: $request, model: $admin, textFields: $textFields) ;
    }

    private function updateAdminPermissions(Request $request, Admin $admin): bool
    {
        $updatedPermissions = false;
        if ($request->has('permissions') && !empty($request->permissions)) {
            $permissions = $request->permissions;
            $currentPermissions = $admin->permissions()->pluck('permission_id')->toArray();
            if (array_diff($currentPermissions, $permissions) || array_diff($permissions, $currentPermissions)) {
                $admin->permissions()->sync($permissions);
                $updatedPermissions = true;
            }
        }

        return $updatedPermissions;
    }

    private function logAdminUpdate(Admin $admin, bool $updatedPermissions)
    {
        // تسجيل الحدث في Observer
        $adminObserver = new AdminObserver();
        $adminObserver->updated($admin);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // العثور على المستخدم باستخدام الـ ID
        $admin = Admin::findOrFail($id);
        $admin->delete();

        return response()->json(['message' => 'تم حذف المستخدم بنجاح']);
    }

}
