<?php

namespace App\Listeners;

use App\Events\AdminLoggedIn;
use App\Models\AdminAction;

class LogAdminLogin
{
    /**
     * التعامل مع حدث تسجيل الدخول للمستخدم.
     *
     * @param  AdminLoggedIn  $event
     * @return void
     */
    public function handle(AdminLoggedIn $event)
    {
        AdminAction::create([
            'user_id' => $event->user->id, // معرف المستخدم الذي قام بتسجيل الدخول
            'action' => 'تسجيل دخول', // نوع الحدث
            'affected_table' => 'المستخدمين', // اسم الجدول المتأثر
            'affected_id' => $event->user->id, // معرف الصف المتأثر
            'description' => 'قام المستخدم بتسجيل الدخول: ' . $event->user->name, // وصف الحدث
        ]);
    }
}
