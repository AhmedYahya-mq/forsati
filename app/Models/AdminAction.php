<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminAction extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'admin_id',  // أضف user_id هنا للسماح بالـ mass assignment
        'action',
        'description',
        'affected_table',
        'affected_id',
        // إضافة أي حقول أخرى تريد السماح بها في mass assignment
    ];
}
