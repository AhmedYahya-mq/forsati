<?php
namespace App\Http\Middleware;

use Closure;

class SanitizeInput
{
    protected $excludedFields = [
        "content_ar",
        "content_en",
    ];
    protected $allowedTags = '<input><b><i><strong><u><p>';

    public function handle($request, Closure $next)
    {
        $input = $request->all();

        // تنقية الحقول غير المستثناة فقط
        array_walk_recursive($input, function (&$input, $key) {
            if (in_array($key, $this->excludedFields)) {
                // إزالة وسوم JavaScript فقط من الحقول المستثناة
                $input = $this->removeJsTags($input);
            } else {
                // إزالة جميع الوسوم، مع السماح فقط بالوسوم المحددة (input)
                $input = strip_tags($input, $this->allowedTags);
            }
        });

        // تحديث الطلب بالمدخلات المنقاة
        $request->merge($input);

        return $next($request);
    }

    // دالة لإزالة وسوم JavaScript فقط
    private function removeJsTags($input)
    {
        // إزالة جميع وسوم <script> وأي وسوم تحتوي على JavaScript
        $input = preg_replace('/<script\b[^>]*>(.*?)<\/script>/is', "", $input);

        // إزالة أي سمات مرتبطة بـ JavaScript (مثل onclick="...")
        $input = preg_replace('/on\w+="[^"]*"/i', "", $input);

        return $input;
    }
}
