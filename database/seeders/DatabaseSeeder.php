<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // استدعاء Seeder لإضافة الصلاحيات
        $this->call([
            PermissionsSeeder::class,
            CountriesSeeder::class,
            DegreeLevelsSeeder::class,
            // ScholarshipsTableSeeder::class,
        ]);

        // إنشاء مستخدمين تجريبيين
        Admin::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password'), // تأكد من إضافة كلمة مرور مشفرة
            'is_admin' => true, // إذا كنت ترغب في جعل المستخدم مشرف
        ]);

        // يمكنك إضافة المزيد من المستخدمين حسب الحاجة
        // User::factory(10)->create(); // إنشاء 10 مستخدمين عشوائيين باستخدام المصنع
    }
}
