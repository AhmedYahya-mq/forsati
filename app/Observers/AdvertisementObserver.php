<?php

namespace App\Observers;

use App\Models\AdminAction;
use App\Models\Advertisement;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AdvertisementObserver
{
    /**
     * التعامل مع حدث "إنشاء" التخصص.
     */
    public function created(Advertisement $advertisement): void
    {
        $userId = Auth::user()->id;
        $affectedId = $advertisement->id;
        $action = 'إنشاء';
        $description = 'تم إنشاء الأعلان: ' . $advertisement->title;
        $tableName = 'الأعلانات';
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
    public function updated(Advertisement $advertisement): void
    {
        // الحصول على القيم القديمة
        $original = $advertisement->getOriginal();
        // الحصول على القيم الجديدة (المحدثة)
        $changes = $advertisement->getChanges();

        $description = 'تم تحديث بيانات الأعلان: ' . $advertisement->title . ". التغييرات: <br>";

        // إضافة تفاصيل التغييرات في الخصائص الأخرى
        foreach ($changes as $key => $newValue) {
            $oldValue = $original[$key]; // الحصول على القيمة القديمة
            $description .= "<div class='event-advertisement'>$key: <strong>من</strong> '$oldValue' <strong>إلى</strong> '$newValue';</div>"; // إضافة وصف التغيير
        }

        // إعداد بيانات تسجيل الحدث
        $userId = Auth::user()->id;
        $affectedId = $advertisement->id;
        $action = 'تحديث';
        $tableName = 'الأعلانات';

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
    public function deleted(Advertisement $advertisement): void
    {
        $userId = Auth::user()->id;
        $affectedId = $advertisement->id;
        $action = 'حذف';
        $description = 'تم حذف تخصص: ' . $advertisement->title;
        $tableName = 'الأعلانات';
        AdminAction::create([
            'admin_id' => $userId,
            'action' => $action,
            'affected_table' => $tableName,
            'affected_id' => $affectedId,
            'description' => $description,
        ]);
        $oldImagePath=$advertisement->mobile_image;
        // حذف الصورة القديمة إذا تم تحديثها
        if (!empty($oldImagePath) && Storage::disk('public')->exists($oldImagePath)) {
            Storage::disk('public')->delete($oldImagePath);
        }

        $oldImagePath=$advertisement->desktop_image;
        // حذف الصورة القديمة إذا تم تحديثها
        if (!empty($oldImagePath) && Storage::disk('public')->exists($oldImagePath)) {
            Storage::disk('public')->delete($oldImagePath);
        }

    }

    /**
     * التعامل مع حدث "استعادة" التخصص.
     */
    public function restored(Advertisement $advertisement): void
    {
        $userId = Auth::user()->id;
        $affectedId = $advertisement->id;
        $action = 'استعادة';
        $description = 'تم استعادة تخصص: ' . $advertisement->title;
        $tableName = 'الأعلانات';
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
    public function forceDeleted(Advertisement $advertisement): void
    {
        $userId = Auth::user()->id;
        $affectedId = $advertisement->id;
        $action = 'حذف قسري';
        $description = 'تم حذف تخصص قسريًا: ' . $advertisement->title;
        $tableName = 'الأعلانات';
        AdminAction::create([
            'admin_id' => $userId,
            'action' => $action,
            'affected_table' => $tableName,
            'affected_id' => $affectedId,
            'description' => $description,
        ]);
        $oldImagePath=$advertisement->mobile_image;
        // حذف الصورة القديمة إذا تم تحديثها
        if (!empty($oldImagePath) && Storage::disk('public')->exists($oldImagePath)) {
            Storage::disk('public')->delete($oldImagePath);
        }

        $oldImagePath=$advertisement->desktop_image;
        // حذف الصورة القديمة إذا تم تحديثها
        if (!empty($oldImagePath) && Storage::disk('public')->exists($oldImagePath)) {
            Storage::disk('public')->delete($oldImagePath);
        }
    }
}
