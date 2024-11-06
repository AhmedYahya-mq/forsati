<?php
namespace App\Observers;

use App\Models\AdminAction;
use App\Models\Specialization;
use Illuminate\Support\Facades\Auth;

class SpecializationObserver
{
    /**
     * التعامل مع حدث "إنشاء" التخصص.
     */
    public function created(Specialization $specialization): void
    {
        $userId = Auth::user()->id;
        $affectedId = $specialization->id;
        $action = 'إنشاء';
        $description = 'تم إنشاء تخصص: ' . $specialization->name_ar;
        $tableName = 'التخصصات';
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
    public function updated(Specialization $specialization): void
    {
        // الحصول على القيم القديمة
        $original = $specialization->getOriginal();
        // الحصول على القيم الجديدة (المحدثة)
        $changes = $specialization->getChanges();

        $description = 'تم تحديث بيانات التخصص: ' . $specialization->name_ar . ". التغييرات: <br>";

        // إضافة تفاصيل التغييرات في الخصائص الأخرى
        foreach ($changes as $key => $newValue) {
            $oldValue = $original[$key]; // الحصول على القيمة القديمة
            $description .= "<div class='event-specialization'>$key: <strong>من</strong> '$oldValue' <strong>إلى</strong> '$newValue';</div>"; // إضافة وصف التغيير
        }

        // إعداد بيانات تسجيل الحدث
        $userId = Auth::user()->id;
        $affectedId = $specialization->id;
        $action = 'تحديث';
        $tableName = 'التخصصات';

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
    public function deleted(Specialization $specialization): void
    {
        $userId = Auth::user()->id;
        $affectedId = $specialization->id;
        $action = 'حذف';
        $description = 'تم حذف تخصص: ' . $specialization->name_ar;
        $tableName = 'التخصصات';
        AdminAction::create([
            'admin_id' => $userId,
            'action' => $action,
            'affected_table' => $tableName,
            'affected_id' => $affectedId,
            'description' => $description,
        ]);
    }

    /**
     * التعامل مع حدث "استعادة" التخصص.
     */
    public function restored(Specialization $specialization): void
    {
        $userId = Auth::user()->id;
        $affectedId = $specialization->id;
        $action = 'استعادة';
        $description = 'تم استعادة تخصص: ' . $specialization->name_ar;
        $tableName = 'التخصصات';
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
    public function forceDeleted(Specialization $specialization): void
    {
        $userId = Auth::user()->id;
        $affectedId = $specialization->id;
        $action = 'حذف قسري';
        $description = 'تم حذف تخصص قسريًا: ' . $specialization->name_ar;
        $tableName = 'التخصصات';
        AdminAction::create([
            'admin_id' => $userId,
            'action' => $action,
            'affected_table' => $tableName,
            'affected_id' => $affectedId,
            'description' => $description,
        ]);
    }
}
