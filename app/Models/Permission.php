<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;

    protected $table = 'permissions'; // تأكد من أن الاسم صحيح
    protected $primaryKey = 'id'; // إذا كان لديك اسم مختلف للمفتاح الأساسي
    public $incrementing = false; // إذا كان id نصي وليس عدد صحيح
    protected $keyType = 'string'; // إذا كان id نصي

    protected $fillable = [
        'id', // معرف الصلاحية
        'text', // نص الصلاحية
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'admin_permissions'); // علاقة مع جدول المستخدمين
    }
}
