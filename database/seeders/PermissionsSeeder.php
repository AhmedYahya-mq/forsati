<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionsSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            ['id' => 'manage_all', 'text' => 'إدارة كل شي'],
            ['id' => 'manage_blogs', 'text' => 'إدارة المدونات'],
            ['id' => 'manage_users', 'text' => 'إدارة المستخدمين'],
            ['id' => 'manage_content', 'text' => 'إدارة المحتوى'],
            ['id' => 'manage_specializations', 'text' => 'إدارة التخصصات'],
            ['id' => 'manage_scholarships', 'text' => 'إدارة المنح']
        ];

        // إدخال الدول إلى قاعدة البيانات
        DB::table('permissions')->insert($permissions);
    }
}
