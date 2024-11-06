<?php
namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = ['content', 'user_id', 'scholarship_id', 'blog_id', 'parent_id'];

    public function user()
    {
        return $this->belongsTo(User::class); // علاقة مع المستخدم
    }

    public function scholarship()
    {
        return $this->belongsTo(Scholarship::class); // علاقة مع المنحة
    }

    public function blog()
    {
        return $this->belongsTo(Blog::class); // علاقة مع المدونة
    }

    // العلاقة مع التعليقات الفرعية (الردود)
    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_id')->with('replies.user'); // التعليقات المرتبطة (الردود)
    }

    public function timeAgo()
    {
        // تأكد من أن `created_at` معرف
        if ($this->created_at) {
            $date = Carbon::parse($this->created_at);
            return $date->diffForHumans();
        }

        // في حالة عدم وجود تاريخ، يمكن إرجاع رسالة بديلة
        return "تاريخ غير معروف";
    }
}
