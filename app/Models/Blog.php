<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;

    protected $fillable = [
        'title_ar',
        'title_en',
        "slug_ar",
        "slug_en",
        'description_ar',
        'description_en',
        'content_ar',
        'content_en',
        'image',
        'admin_id'
    ];

    /**
     * Get the user that owns the blog.
     */
    public function user()
    {
        return $this->belongsTo(Admin::class);
    }

    /**
     * Get the comments for the blog.
     */
    public function comments()
    {
        return $this->hasMany(Comment::class); // علاقة مع التعليقات
    }
}
