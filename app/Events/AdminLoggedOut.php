<?php

namespace App\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Auth\Authenticatable;

class AdminLoggedOut
{
    use Dispatchable, SerializesModels;

    public $user; // متغير لتخزين معلومات المستخدم

    /**
     * إنشاء حدث تسجيل الخروج.
     *
     * @param  Authenticatable  $user
     * @return void
     */
    public function __construct(Authenticatable $user)
    {
        $this->user = $user; // تخزين معلومات المستخدم
    }
}
