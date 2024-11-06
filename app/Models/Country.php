<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;
    protected $table = 'countries';
    protected $primaryKey = '_id';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        "_id",
        "flag",
        "name_ar",
        "name_en",
    ];
    // علاقة مع المستخدمين
    public function users()
    {
        return $this->hasMany(User::class, 'country_id',"_id");
    }

    // علاقة مع المنح
    public function scholarships()
    {
        return $this->hasMany(Scholarship::class, 'country_id',"_id");
    }
}
