<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailsUser extends Model
{
    use HasFactory;
    protected $table="details_user";
    protected $fillable=['user_id', 'bio', 'gender', 'birthday', 'phone', 'twitter', 'facebook', 'linkedin', 'google', 'instagram', 'notification'];
    protected $casts = [
        'notification' => 'array',
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
