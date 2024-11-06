<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('advertisements', function (Blueprint $table) {
            $table->id(); // معرف الإعلان
            $table->string('title'); // عنوان الإعلان
            $table->text('content')->nullable(); // محتوى الإعلان
            $table->text('url'); // محتوى الإعلان
            $table->string('mobile_image')->nullable(); // صورة الهاتف (اختياري)
            $table->string('desktop_image')->nullable(); // صورة الحاسوب (اختياري)
            $table->timestamp('start_date')->nullable(); // تاريخ بداية العرض
            $table->timestamp('end_date')->nullable(); // تاريخ انتهاء العرض
            $table->boolean('isActivate')->default(true);
            $table->timestamps(); // لتسجيل وقت الإنشاء والتحديث
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('advertisements');
    }
};
