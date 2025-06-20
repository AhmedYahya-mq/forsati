<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Resources\CommentResource;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function __invoke($type, $id)
    {
        $field = $type === 'blog' ? 'blog_id' : 'scholarship_id';

         $comments=Comment::with(["user", "replies.user"])
                    ->where($field, $id)
                    ->whereNull("parent_id")
                    ->paginate(10);

        return CommentResource::collection($comments)->additional([
            'total_pages' => $comments->lastPage(),
            'next_page' => $comments->nextPageUrl(),
        ]);
    }

    public function addComment(Request $request)
    {
        // التحقق من صحة البيانات وتحديد المدخلات المتوقعة فقط
        $validatedData = $request->validate([
            'content' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:comments,id', // تحقق من وجود تعليق الأب إذا كان موجودًا
            'blog_id' => 'nullable|exists:blogs,id', // تحقق من صحة blog_id إذا وُجد
            'scholarship_id' => 'nullable|exists:scholarships,id', // تحقق من صحة scholarship_id إذا وُجد
        ]);

        // تحقق من المصادقة (في حال كنت تستخدم التوكن للمصادقة)
        if (!$request->user()) {
            return response()->json([
                'error' => 'Unauthorized'
            ], 401);
        }

        try {
            // إضافة التعليق باستخدام الإنشاء السريع
            $comment = Comment::create([
                'content' => $validatedData['content'],
                'user_id' => $request->user()->id, // استخدام user المصادق عليه
                'parent_id' => $validatedData['parent_id'],
                'blog_id' => $validatedData['blog_id'] ?? null,
                'scholarship_id' => $validatedData['scholarship_id'] ?? null,
            ]);

            return response()->json(new CommentResource($comment)
            , 201); // رمز الحالة 201 يعبر عن النجاح في الإنشاء

        } catch (\Exception $e) {
            // التعامل مع الأخطاء وإرجاع رسالة توضيحية
            return response()->json([
                'error' => 'Failed to add comment',
                'details' => $e->getMessage(),
            ], 500); // رمز الحالة 500 يعني خطأ في الخادم
        }
    }

}
