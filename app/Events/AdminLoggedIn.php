<?php

namespace App\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Auth\Authenticatable;

class AdminLoggedIn
{
    use Dispatchable, SerializesModels;

    public $user; // متغير لتخزين معلومات المستخدم

    /**
     * إنشاء حدث تسجيل الدخول.
     *
     * @param  Authenticatable  $user
     * @return void
     */
    public function __construct(Authenticatable $user)
    {
        $this->user = $user; // تخزين معلومات المستخدم
    }
}
