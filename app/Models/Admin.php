<?php

namespace App\Models;

use App\Models\Permission;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\PersonalAccessToken;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    use HasApiTokens,HasFactory, Notifiable;

    protected $guard="admin";
    protected $table="users";

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
        return $this->belongsToMany(related: Permission::class, table: 'admin_permissions'); // علاقة مع جدول الصلاحيات
    }


    public function hasPermission($permission)
    {
        return $this->permissions()->where('permission_id', $permission)->exists();
    }

     // أو إذا كانت صلاحية المشرف تحمل اسم مختلف مثل manage_admin
    public function isSuperAdmin(): bool
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

}
