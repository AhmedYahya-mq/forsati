<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CountriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $countries = json_decode(file_get_contents(storage_path('app/countries.json')), true);

        // إدخال الدول إلى قاعدة البيانات
        DB::table('countries')->insert($countries);
    }
}
