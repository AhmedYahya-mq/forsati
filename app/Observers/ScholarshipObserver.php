<?php

namespace App\Observers;

use App\Models\AdminAction;
use App\Models\Scholarship;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ScholarshipObserver
{
    /**
     * التعامل مع حدث "إنشاء" المنحة.
     */
    public function created(Scholarship $scholarship): void
    {
        $userId = Auth::user()->id;
        $affectedId = $scholarship->id;
        $action = 'إنشاء';
        $description = 'تم إنشاء منحة: ' . $scholarship->title_ar;
        $tableName = 'المنح الدراسية';
        AdminAction::create([
            'admin_id' => $userId,
            'action' => $action,
            'affected_table' => $tableName,
            'affected_id' => $affectedId,
            'description' => $description,
        ]);
    }

    /**
     * التعامل مع حدث "تحديث" المنحة.
     */
    public function updated(Scholarship $scholarship): void
    {
        // الحصول على القيم القديمة
        $original = $scholarship->getOriginal();
        // الحصول على القيم الجديدة (المحدثة)
        $changes = $scholarship->getChanges();

        $description = 'تم تحديث بيانات المنحة: ' . $scholarship->title_ar . ". التغييرات: <br>";

        // إضافة تفاصيل التغييرات في الخصائص الأخرى
        foreach ($changes as $key => $newValue) {
            $oldValue = $original[$key]; // الحصول على القيمة القديمة
            $description .= "<div class='event-scholarship'>$key: <strong>من</strong> '$oldValue' <strong>إلى</strong> '$newValue';</div>"; // إضافة وصف التغيير
        }

        // إعداد بيانات تسجيل الحدث
        $userId = Auth::user()->id;
        $affectedId = $scholarship->id;
        $action = 'تحديث';
        $tableName = 'المنح الدراسية';

        // تسجيل الحدث في جدول AdminAction
        AdminAction::create([
            'admin_id' => $userId,
            'action' => $action,
            'affected_table' => $tableName,
            'affected_id' => $affectedId,
            'description' => $description,
        ]);
    }

    /**
     * التعامل مع حدث "حذف" المنحة.
     */
    public function deleted(Scholarship $scholarship): void
    {
        $userId = Auth::user()->id;
        $affectedId = $scholarship->id;
        $action = 'حذف';
        $description = 'تم حذف منحة: ' . $scholarship->title_ar;
        $tableName = 'المنح الدراسية';
        AdminAction::create([
            'admin_id' => $userId,
            'action' => $action,
            'affected_table' => $tableName,
            'affected_id' => $affectedId,
            'description' => $description,
        ]);
        $oldImagePath=$scholarship->image;
        // حذف الصورة القديمة إذا تم تحديثها
        if (!empty($oldImagePath) && Storage::disk('public')->exists($oldImagePath)) {
            Storage::disk('public')->delete($oldImagePath);
        }
    }

    /**
     * التعامل مع حدث "استعادة" المنحة.
     */
    public function restored(Scholarship $scholarship): void
    {
        $userId = Auth::user()->id;
        $affectedId = $scholarship->id;
        $action = 'استعادة';
        $description = 'تم استعادة منحة: ' . $scholarship->title_ar;
        $tableName = 'المنح الدراسية';
        AdminAction::create([
            'admin_id' => $userId,
            'action' => $action,
            'affected_table' => $tableName,
            'affected_id' => $affectedId,
            'description' => $description,
        ]);
    }

    /**
     * التعامل مع حدث "الحذف القسري" للمنحة.
     */
    public function forceDeleted(Scholarship $scholarship): void
    {
        $userId = Auth::user()->id;
        $affectedId = $scholarship->id;
        $action = 'حذف قسري';
        $description = 'تم حذف منحة قسريًا: ' . $scholarship->title_ar;
        $tableName = 'المنح الدراسية';
        AdminAction::create([
            'admin_id' => $userId,
            'action' => $action,
            'affected_table' => $tableName,
            'affected_id' => $affectedId,
            'description' => $description,
        ]);
        $oldImagePath=$scholarship->image;
        // حذف الصورة القديمة إذا تم تحديثها
        if (!empty($oldImagePath) && Storage::disk('public')->exists($oldImagePath)) {
            Storage::disk('public')->delete($oldImagePath);
        }
    }
}
