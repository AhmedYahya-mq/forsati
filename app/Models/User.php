<?php

namespace App\Models;

use App\Models\Permission;
use App\Notifications\ResetPasswordNotification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Sanctum\PersonalAccessToken;

class User extends Authenticatable
{
    use HasApiTokens,HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'country_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function tokens()
    {
        return $this->hasMany(PersonalAccessToken::class, 'tokenable_id', 'id');
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'admin_permissions', 'admin_id'); // علاقة مع جدول الصلاحيات
    }


    public function hasPermission($permission)
    {
        return $this->permissions()->where('permission_id', $permission)->exists();
    }

     // أو إذا كانت صلاحية المشرف تحمل اسم مختلف مثل manage_admin
    public function isAdmin(): bool
    {
        return $this->permissions()->where('permission_id', 'manage_all')->exists();
    }

    public function isActive(): bool{
        return $this->status;
    }
    /**
     * Get the comments for the user.
     */
    public function comments()
    {
        return $this->hasMany(Comment::class); // علاقة مع التعليقات
    }

    /**
     * Get the likes for the user.
     */
    public function likes()
    {
        return $this->hasMany(Like::class); // علاقة مع الإعجابات
    }

    /**
     * Get the dislikes for the user.
     */
    public function dislikes()
    {
        return $this->hasMany(Dislike::class); // علاقة مع عدم الإعجابات
    }

    /**
     * Get the scholarships published by the user.
     */
    public function scholarships()
    {
        return $this->hasMany(Scholarship::class); // علاقة مع المنح
    }

    /**
     * Get the blogs published by the user.
     */
    public function blogs()
    {
        return $this->hasMany(Blog::class); // علاقة مع المدونات
    }

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id',"_id");
    }


     /**
     * Override the default password reset notification
     *
     * @param string $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }

}
