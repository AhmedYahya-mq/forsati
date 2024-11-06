<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class ScholarshipsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        $countries = DB::table('countries')->pluck('_id')->toArray();
        $specializations = DB::table('specializations')->pluck('id')->toArray();
        $degree_levels = DB::table('degree_levels')->pluck('id')->toArray();

        $numberOfRecords = 50000; // يمكنك تغيير هذا الرقم حسب الحاجة
        $batchSize = 1000; // عدد السجلات في كل دفعة

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::beginTransaction();

        try {
            for ($i = 0; $i < $numberOfRecords; $i++) {
                // إدخال سجل المنحة
                $scholarshipId = DB::table('scholarships')->insertGetId([
                    'title_ar' => $faker->sentence(5),
                    'title_en' => $faker->sentence(5),
                    'description_ar' => $faker->paragraph,
                    'description_en' => $faker->paragraph,
                    'funding_type' => $faker->randomElement(['full', 'partial', 'private']),
                    'content_ar' => $faker->text,
                    'content_en' => $faker->text,
                    'slug_ar' => $faker->slug,
                    'slug_en' => $faker->slug,
                    'deadline' => $faker->date,
                    'image' => $faker->imageUrl(),
                    'admin_id' => 2, // افترض أن لديك مستخدمين في جدول المستخدمين
                    'country_id' => $faker->randomElement($countries),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                // اختيار عدد عشوائي من التخصصات
                $randomSpecializations = $faker->randomElements($specializations, rand(1, 2)); // 1 إلى 5 تخصصات عشوائية

                // إدخال البيانات في الجدول الوسيط
                foreach ($randomSpecializations as $specializationId) {
                    DB::table('scholarship_specialization')->insert([
                        'scholarship_id' => $scholarshipId,
                        'specialization_id' => $specializationId,
                    ]);
                }

                // اختيار عدد عشوائي من مستويات الدرجات
                $randomDegreeLevels = $faker->randomElements($degree_levels, rand(1, 5)); // 1 إلى 3 مستويات درجات عشوائية

                // إدخال البيانات في الجدول الوسيط
                foreach ($randomDegreeLevels as $degreeLevelId) {
                    DB::table('scholarship_degree_level')->insert([
                        'scholarship_id' => $scholarshipId,
                        'degree_level_id' => $degreeLevelId,
                    ]);
                }

                // إذا وصلنا إلى العدد المحدد من السجلات، قم بإدخالها في قاعدة البيانات
                if (($i + 1) % $batchSize == 0) {
                    DB::commit();
                    DB::beginTransaction();
                }
            }

            DB::commit(); // قم بتأكيد المعاملة
        } catch (\Exception $e) {
            DB::rollBack(); // إذا حدث خطأ، قم بإلغاء المعاملة
            throw $e; // إعادة الرمي للخارج
        } finally {
            DB::statement('SET FOREIGN_KEY_CHECKS=1;'); // إعادة تفعيل قيود المفتاح الخارجي
        }
    }
}
