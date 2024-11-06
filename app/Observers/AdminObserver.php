<?php

namespace App\Observers;

use App\Models\AdminAction;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AdminObserver
{
    /**
     * التعامل مع حدث "إنشاء" المستخدم.
     */
    public function created(Admin $admin): void
    {
        $adminId = Auth::user()->id ?? $admin->id;
        $affectedId = $admin->id;
        $action = 'إنشاء';
        $description = ($admin->is_admin ? 'تم إنشاء مشرف: ' : 'تم إنشاء مستخدم: ') . $admin->name;
        $tableName = 'المستخدمين';
        AdminAction::create([
            'admin_id' => $adminId,
            'action' => $action,
            'affected_table' => $tableName ?? "المستخدمين",
            'affected_id' => $affectedId,
            'description' => $description,
        ]);
    }

    /**
     * التعامل مع حدث "تحديث" المستخدم.
     */
    public function updated(Admin $admin): void
    {
        // الحصول على القيم القديمة
        $original = $admin->getOriginal();
        // الحصول على القيم الجديدة (المحدثة)
        $changes = $admin->getChanges();

        $description = ($admin->is_admin ? 'تم تحديث بيانات المشرف: ' : 'تم تحديث بيانات المستخدم: ') . $admin->name . ". التغييرات: <br>";

        // إضافة تفاصيل التغييرات في الخصائص الأخرى
        foreach ($changes as $key => $newValue) {
            $oldValue = $original[$key]; // الحصول على القيمة القديمة
            $description .= "<div class='event-user'>$key:   <strong>من</strong>   '$oldValue'    <strong>إلى</strong>    '$newValue';</div>"; // إضافة وصف التغيير
        }

        // التحقق من صلاحيات المستخدم
        $oldPermissions = $original['permissions'] ?? []; // الحصول على الصلاحيات القديمة
        $newPermissions = $admin->permissions->pluck('text')->toArray(); // الحصول على الصلاحيات الجديدة

        // تحديد الصلاحيات المحذوفة
        $removedPermissions = array_diff($oldPermissions, $newPermissions);
        // تحديد الصلاحيات المضافة
        $addedPermissions = array_diff($newPermissions, $oldPermissions);

        // إضافة تفاصيل الصلاحيات المعدلة إلى الوصف
        if (!empty($removedPermissions)) {
            $description .= "<div class='event-user'>تم حذف الصلاحيات: " . implode(' , ', $removedPermissions) ."</div>" ;
        }

        if (!empty($addedPermissions)) {
            $description .= 'تم إضافة الصلاحيات: ' . implode(', ', $addedPermissions) . '.<br>';
        }

        // إعداد بيانات تسجيل الحدث
        $adminId = Auth::user()->id ?? $admin->id;
        $affectedId = $admin->id;
        $action = 'تحديث';
        $tableName = 'المستخدمين';

        // تسجيل الحدث في جدول AdminAction
        AdminAction::create([
            'admin_id' => $adminId,
            'action' => $action,
            'affected_table' => $tableName,
            'affected_id' => $affectedId,
            'description' => $description,
        ]);
    }


    /**
     * التعامل مع حدث "حذف" المستخدم.
     */
    public function deleted(Admin $admin): void
    {
        $adminId = Auth::user()->id ?? $admin->id;
        $affectedId = $admin->id;
        $action = 'إنشاء';
        $description = ($admin->is_admin ? 'تم حذف مشرف: ' : 'تم حذف مستخدم: ') . $admin->name;
        $tableName = 'المستخدمين';
        AdminAction::create([
            'admin_id' => $adminId,
            'action' => $action,
            'affected_table' => $tableName ?? "المستخدمين",
            'affected_id' => $affectedId,
            'description' => $description,
        ]);
        $oldImagePath=$admin->image;
         // حذف الصورة القديمة إذا تم تحديثها
        if (!empty($oldImagePath) && Storage::disk('public')->exists($oldImagePath)) {
            Storage::disk('public')->delete($oldImagePath);
        }
        $admin->permissions()->detach();
        $admin->tokens()->delete();
    }

    /**
     * التعامل مع حدث "استعادة" المستخدم.
     */
    public function restored(Admin $admin): void
    {
        $adminId = Auth::user()->id ?? $admin->id;
        $affectedId = $admin->id;
        $action = 'أستعاده';
        $description =($admin->is_admin ? 'تم استعادة مشرف: ' : 'تم استعادة مستخدم: ') . $admin->name;
        $tableName = 'المستخدمين';
        AdminAction::create([
            'admin_id' => $adminId,
            'action' => $action,
            'affected_table' => $tableName ?? "المستخدمين",
            'affected_id' => $affectedId,
            'description' => $description,
        ]);
    }

    /**
     * التعامل مع حدث "الحذف القسري" للمستخدم.
     */
    public function forceDeleted(Admin $admin): void
    {
        $adminId = Auth::user()->id ?? $admin->id;
        $affectedId = $admin->id;
        $action = 'حذف قسري';
        $description =($admin->is_admin ? 'تم حذف مشرف قسريًا: ' : 'تم حذف مستخدم قسريًا: ') . $admin->name;
        $tableName = 'المستخدمين';
        AdminAction::create([
            'admin_id' => $adminId,
            'action' => $action,
            'affected_table' => $tableName ?? "المستخدمين",
            'affected_id' => $affectedId,
            'description' => $description,
        ]);
        $oldImagePath=$admin->image;
         // حذف الصورة القديمة إذا تم تحديثها
        if (!empty($oldImagePath) && Storage::disk('public')->exists($oldImagePath)) {
            Storage::disk('public')->delete($oldImagePath);
        }

        $admin->permissions()->detach();
        $admin->tokens()->delete();
    }
}
