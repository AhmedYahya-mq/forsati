<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DegreeLevelsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $degreeLevels = [
            ['name_ar' => 'بكالوريوس', 'name_en' => 'Bachelor'],
            ['name_ar' => 'ماجستير', 'name_en' => 'Master'],
            ['name_ar' => 'دكتوراه', 'name_en' => 'PhD'],
            ['name_ar' => 'دبلوم', 'name_en' => 'Diploma'],
            ['name_ar' => 'شهادة مهنية', 'name_en' => 'Professional Certificate'],
        ];

        DB::table('degree_levels')->insert($degreeLevels);
    }
}
