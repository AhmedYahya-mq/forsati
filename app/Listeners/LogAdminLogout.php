<?php

namespace App\Listeners;

use App\Events\AdminLoggedOut;
use App\Models\AdminAction;

class LogAdminLogout
{
    /**
     * التعامل مع حدث تسجيل خروج المستخدم.
     *
     * @param  AdminLoggedOut  $event
     * @return void
     */
    public function handle(AdminLoggedOut $event)
    {
        AdminAction::create([
            'user_id' => $event->user->id, // معرف المستخدم الذي قام بتسجيل الخروج
            'action' => 'تسجيل خروج', // نوع الحدث
            'affected_table' => 'المستخدمين', // اسم الجدول المتأثر
            'affected_id' => $event->user->id, // معرف الصف المتأثر
            'description' => 'قام المستخدم بتسجيل الخروج: ' . $event->user->name, // وصف الحدث
        ]);
    }
}
