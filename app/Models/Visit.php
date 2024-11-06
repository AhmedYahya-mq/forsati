<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Visit extends Model
{
    use HasFactory;

    // تحديد اسم الجدول إذا كان مختلفًا عن الاسم الافتراضي
    protected $table = 'visits';

    // الحقول القابلة للتعبئة
    protected $fillable = [
        'country_id',
        'country_name',
        'city',
        'region',
        'session_id',
        'scholarship_id',
    ];

    // العلاقة مع sessions
    public function session()
    {
        return $this->belongsTo(Session::class, 'session_id', 'id');
    }

    // العلاقة مع جدول scholarships
    public function scholarship()
    {
        return $this->belongsTo(Scholarship::class);
    }

    // العلاقة مع جدول countries
    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id', '_id');
    }
}
