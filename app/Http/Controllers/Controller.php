<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

abstract class Controller
{
    protected const perPage=10;
    protected $dirImage = "";
    protected $fileKeys = [
        "image",
    ];
    protected $locale = "ar";
    public function __construct(){
        $this->locale = Cookie::get('locale', config('app.locale'));
        // ضبط اللغة للتطبيق
        App::setLocale($this->locale);
    }
    protected function getPermissions(){
        return Auth::guard('admin')->user()->permissions;
    }
    /**
     * دالة للتحقق مما إذا كان هناك ملف مرفوع وإرجاع المفتاح الخاص به.
     */
    private function getUploadedFileKey(Request $request)
    {
        foreach ($this->fileKeys as $key) {
            if ($request->hasFile($key)) {
                return $key;
            }
        }
        return null;
    }

    /**
     * رفع صورة مؤقتة
     */
    public function uploadImageTemp(Request $request)
    {
        Gate::authorize('view', [$request->user('admin'), \App\Models\Admin::class]);

        // إنشاء مجلد 'temp' إذا لم يكن موجودًا
        if (!Storage::disk('public')->exists('temp')) {
            Storage::disk('public')->makeDirectory('temp');
        }

        $key= $this->getUploadedFileKey($request);
        // التحقق من أن الطلب يحتوي على ملف
        if ($request->hasFile($key)) {
            // تحقق من صحة الملف
            $request->validate([
                $key => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:3070',
            ], [
                "{$key}.required" => 'يجب رفع صورة.',
                "{$key}.image" => 'يجب أن يكون الملف المرفوع صورة.',
                "{$key}.mimes" => 'صيغة الصورة يجب أن تكون jpeg, png, jpg, gif, أو svg.',
                "{$key}.max" => 'حجم الصورة لا يجب أن يتجاوز 3 ميغابايت.',
            ]);


            // إنشاء اسم عشوائي جديد
            $newName = 'temp_' . Str::random(10) . '.' . $request->file($key)->extension();

            // حفظ الصورة
            $path = $request->file($key)->storeAs('temp', $newName, 'public');

            return response()->json(['path' => $path, "message" => "تم رفع الصورة بنجاح"], 200);
        }

        return response()->json(['message' => 'لم يتم رفع الصورة'], 400);
    }

    /**
     * حذف صورة مؤقتة
     */
    public function deleteTempImage(Request $request)
    {
        Gate::authorize('view', [$request->user('admin'), \App\Models\Admin::class]);

        // جلب المسار من الطلب
        $tempPath = $request->getContent();

        // تحقق من أن المسار موجود
        if (!$tempPath) {
            return response()->json(['message' => 'لا يوجد ملف صوره على السيرفر'], 400);
        }

        // تحقق من أن الملف موجود في التخزين
        if (Storage::disk('public')->exists($tempPath)) {
            // حذف الملف
            Storage::disk('public')->delete($tempPath);
            return response()->json(['message' => 'تم حذف الصورة بنجاح'], 200);
        }

        return response()->json(['message' => 'لا توجد صورة: ' . $tempPath], 404);
    }

    /**
     * التعامل مع الصور (نقل من المؤقت إلى الدائم)
     */
    protected function hndlerImage($newImagePath, $oldImagePath = "", $isUpdate = false)
    {
        // المسار النهائي للصورة
        $finalPath = "upload/images/{$this->dirImage}" . basename($newImagePath);

        // نقل الصورة الجديدة
        Storage::disk('public')->move($newImagePath, $finalPath);

        // التحقق من حذف الصورة المؤقتة
        if (Storage::disk('public')->exists($newImagePath)) {
            Storage::disk('public')->delete($newImagePath);
        }

        // حذف الصورة القديمة إذا تم تحديثها
        if ($isUpdate && !empty($oldImagePath) && Storage::disk('public')->exists($oldImagePath)) {
            Storage::disk('public')->delete($oldImagePath);
        }

        return $finalPath;
    }

    function makeSlug($string) {
        $string = mb_strtolower($string, 'UTF-8');
        $string = preg_replace('/[^\p{L}\p{N}]+/u', '-', $string);
        $string = trim($string, '-');
        return $string;
    }
    /**
     * تحديث بيانات النموذج.
     *
     * @param Request $request
     * @param Model $model
     * @param array $textFields الحقول النصية التي يمكن تحديثها
     * @param array $fileFields الحقول التي تتطلب ملفات (مثل الصور)
     * @param array $relationFields العلاقات التي سيتم تحديثها
     * @return bool
     */
    protected function updateModelData(Request $request, Model $model, array $textFields=[], array $fileFields=[], array $dateFields=[], array $relationFields=[],$updated=false): bool
    {
        // تحديث الحقول النصية
        $updated = $this->updateTextFields($request, $model, $textFields) || $updated;


        // تحديث الملفات (إذا تم تضمينها في المصفوفة)
        foreach ($fileFields as $fileField) {
            $updated = $this->updateFile($request, $model, $fileField) || $updated;
        }

        // تحديث الحقول التي تحتوي على تواريخ
        if (!empty($dateFields)) {
            $updated = $this->updateDateFields($request, $model, $dateFields) || $updated;
        }

        // تحديث العلاقات المتعددة
        foreach ($relationFields as $relation => $key) {
            $updated = $this->updateRelations($request, $model, $relation, $key) || $updated;
        }

        // حفظ التغييرات إذا تم التحديث
        if ($updated) {
            $model->save();
        }

        return $updated;
    }

    protected function updateDateFields(Request $request, Model $model, array $dateFields, string $format = 'Y-m-d'): bool
    {
        $updated = false;

        foreach ($dateFields as $field) {
            if ($request->has($field) && !empty($request->$field)) {
                try {
                    // تحويل التاريخ الذي يأتي من المستخدم إلى التنسيق المحدد
                    $newDate = \Carbon\Carbon::createFromFormat($format, $request->$field)->format($format);

                    // تحويل التاريخ المخزن في قاعدة البيانات إلى نفس التنسيق للمقارنة
                    $oldDate = \Carbon\Carbon::parse($model->$field)->format($format);
                    // مقارنة التواريخ بعد تحويلها إلى نفس التنسيق
                    if ($newDate !== $oldDate) {
                        $model->$field = $newDate;
                        $updated = true;
                    }
                } catch (\Exception $e) {
                    // يمكنك تسجيل الخطأ هنا إذا كان التاريخ غير صالح
                }
            }
        }

        return $updated;
    }



    /**
     * تحديث الحقول النصية.
     *
     * @param Request $request
     * @param Model $model
     * @param array $fieldsToUpdate
     * @return bool
     */
    protected function updateTextFields(Request $request, Model $model, array $fieldsToUpdate): bool
    {
        $updated = false;

        foreach ($fieldsToUpdate as $field) {
            if ($request->has($field) && !empty($request->$field) && $request->$field !== $model->$field) {
                $model->$field = $request->$field;
                $updated = true;
            }
        }

        return $updated;
    }

    /**
     * تحديث ملف (مثل صورة).
     *
     * @param Request $request
     * @param Model $model
     * @param string $fileField
     * @return bool
     */
    protected function updateFile(Request $request, Model $model, string $fileField): bool
    {
        if ($request->has($fileField) && !empty($request->$fileField)) {
            $oldFilePath = $model->$fileField;
            $model->$fileField = $this->hndlerImage($request->$fileField);

            // حذف الملف القديم إذا تم تحديثه
            if (!empty($oldFilePath) && Storage::disk('public')->exists($oldFilePath)) {
                Storage::disk('public')->delete($oldFilePath);
            }

            return true;
        }

        return false;
    }

    /**
     * تحديث العلاقات المشتركة (علاقة متعددة مع نموذج آخر).
     *
     * @param Request $request
     * @param Model $model
     * @param string $relation
     * @param string $key
     * @return bool
     */
    protected function updateRelations(Request $request, Model $model, string $relation, string $key): bool
    {
        if ($request->has($relation) && is_array($request->$relation)) {
            $currentRelations = $model->$relation()->pluck($key)->toArray();

            // إضافة العلاقات الجديدة
            $newRelations = array_diff($request->$relation, $currentRelations);
            if (!empty($newRelations)) {
                $model->$relation()->attach($newRelations);
            }

            // حذف العلاقات القديمة
            $removedRelations = array_diff($currentRelations, $request->$relation);
            if (!empty($removedRelations)) {
                $model->$relation()->detach($removedRelations);
            }

            return !empty($newRelations) || !empty($removedRelations);
        }

        return false;
    }


}
