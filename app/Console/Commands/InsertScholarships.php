<?php


namespace App\Console\Commands;

use Faker\Factory as Faker;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class InsertScholarships extends Command
{
    protected $signature = 'insert:scholarships {count=500000}';
    protected $description = 'Insert dummy scholarship data into the database';

    public function handle()
    {
        $faker = Faker::create();
        $countries = DB::table('countries')->pluck('_id')->toArray();
        $specializations = DB::table('specializations')->pluck('id')->toArray();
        $degree_levels = DB::table('degree_levels')->pluck('id')->toArray();

        $numberOfRecords = $this->argument('count');
        $batchSize = 1000; // عدد السجلات في كل دفعة

        DB::statement('SET FOREIGN_KEY_CHECKS=0;'); // تعطيل قيود المفاتيح الخارجية مؤقتًا
        DB::beginTransaction();

        try {
            $scholarshipData = [];
            $specializationData = [];
            $degreeLevelData = [];

            for ($i = 0; $i < $numberOfRecords; $i++) {
                // جمع بيانات المنحة في مصفوفة
                $scholarshipData[] = [
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
                    'user_id' => 2, // افترض أن لديك مستخدمين في جدول المستخدمين
                    'country_id' => $faker->randomElement($countries),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];

                // اختيار عدد عشوائي من التخصصات
                $randomSpecializations = $faker->randomElements($specializations, rand(1, 2));
                foreach ($randomSpecializations as $specializationId) {
                    $specializationData[] = [
                        'scholarship_id' => $i + 1, // افتراض أن المعرف يتزايد تلقائيًا
                        'specialization_id' => $specializationId,
                    ];
                }

                // اختيار عدد عشوائي من مستويات الدرجات
                $randomDegreeLevels = $faker->randomElements($degree_levels, rand(1, 3));
                foreach ($randomDegreeLevels as $degreeLevelId) {
                    $degreeLevelData[] = [
                        'scholarship_id' => $i + 1, // افتراض أن المعرف يتزايد تلقائيًا
                        'degree_level_id' => $degreeLevelId,
                    ];
                }

                // إدخال البيانات دفعة واحدة بعد كل دفعة
                if (count($scholarshipData) >= $batchSize) {
                    DB::table('scholarships')->insert($scholarshipData);
                    DB::table('scholarship_specialization')->insert($specializationData);
                    DB::table('scholarship_degree_level')->insert($degreeLevelData);

                    // تفريغ المصفوفات
                    $scholarshipData = [];
                    $specializationData = [];
                    $degreeLevelData = [];
                }
            }

            // إدخال أي بيانات متبقية
            if (!empty($scholarshipData)) {
                DB::table('scholarships')->insert($scholarshipData);
                DB::table('scholarship_specialization')->insert($specializationData);
                DB::table('scholarship_degree_level')->insert($degreeLevelData);
            }

            DB::commit(); // تأكيد المعاملة
            $this->info('Data inserted successfully!');
        } catch (\Exception $e) {
            DB::rollBack(); // إذا حدث خطأ، قم بإلغاء المعاملة
            $this->error('Failed to insert data: ' . $e->getMessage());
        } finally {
            DB::statement('SET FOREIGN_KEY_CHECKS=1;'); // إعادة تفعيل قيود المفاتيح الخارجية
        }
    }
}
