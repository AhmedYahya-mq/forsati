<?php

namespace App\Observers;

use App\Models\Blog;
use App\Models\AdminAction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class BlogObserver
{
   /**
     * التعامل مع حدث "إنشاء" التخصص.
     */
    public function created(Blog $blog): void
    {
        $userId = Auth::user()->id;
        $affectedId = $blog->id;
        $action = 'إنشاء';
        $description = 'تم إنشاء المدونة: ' . $blog->title_ar;
        $tableName = 'المدونات';
        AdminAction::create([
            'admin_id' => $userId,
            'action' => $action,
            'affected_table' => $tableName,
            'affected_id' => $affectedId,
            'description' => $description,
        ]);
    }

    /**
     * التعامل مع حدث "تحديث" التخصص.
     */
    public function updated(Blog $blog): void
    {
        // الحصول على القيم القديمة
        $original = $blog->getOriginal();
        // الحصول على القيم الجديدة (المحدثة)
        $changes = $blog->getChanges();

        $description = 'تم تحديث بيانات المدونة: ' . $blog->title_ar . ". التغييرات: <br>";

        // إضافة تفاصيل التغييرات في الخصائص الأخرى
        foreach ($changes as $key => $newValue) {
            $oldValue = $original[$key]; // الحصول على القيمة القديمة
            $description .= "<div class='event-blog'>$key: <strong>من</strong> '$oldValue' <strong>إلى</strong> '$newValue';</div>"; // إضافة وصف التغيير
        }

        // إعداد بيانات تسجيل الحدث
        $userId = Auth::user()->id;
        $affectedId = $blog->id;
        $action = 'تحديث';
        $tableName = 'المدونات';

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
     * التعامل مع حدث "حذف" التخصص.
     */
    public function deleted(Blog $blog): void
    {
        $userId = Auth::user()->id;
        $affectedId = $blog->id;
        $action = 'حذف';
        $description = 'تم حذف مدونة: ' . $blog->title_ar;
        $tableName = 'المدونات';
        AdminAction::create([
            'admin_id' => $userId,
            'action' => $action,
            'affected_table' => $tableName,
            'affected_id' => $affectedId,
            'description' => $description,
        ]);
        $oldImagePath=$blog->image;
        // حذف الصورة القديمة إذا تم تحديثها
        if (!empty($oldImagePath) && Storage::disk('public')->exists($oldImagePath)) {
            Storage::disk('public')->delete($oldImagePath);
        }

    }

    /**
     * التعامل مع حدث "استعادة" التخصص.
     */
    public function restored(Blog $blog): void
    {
        $userId = Auth::user()->id;
        $affectedId = $blog->id;
        $action = 'استعادة';
        $description = 'تم استعادة مدونة: ' . $blog->title_ar;
        $tableName = 'المدونات';
        AdminAction::create([
            'admin_id' => $userId,
            'action' => $action,
            'affected_table' => $tableName,
            'affected_id' => $affectedId,
            'description' => $description,
        ]);
    }

    /**
     * التعامل مع حدث "الحذف القسري" للتخصص.
     */
    public function forceDeleted(Blog $blog): void
    {
        $userId = Auth::user()->id;
        $affectedId = $blog->id;
        $action = 'حذف قسري';
        $description = 'تم حذف مدونة قسريًا: ' . $blog->title_ar;
        $tableName = 'المدونات';
        AdminAction::create([
            'admin_id' => $userId,
            'action' => $action,
            'affected_table' => $tableName,
            'affected_id' => $affectedId,
            'description' => $description,
        ]);
        $oldImagePath=$blog->image;
        // حذف الصورة القديمة إذا تم تحديثها
        if (!empty($oldImagePath) && Storage::disk('public')->exists($oldImagePath)) {
            Storage::disk('public')->delete($oldImagePath);
        }
    }
}
