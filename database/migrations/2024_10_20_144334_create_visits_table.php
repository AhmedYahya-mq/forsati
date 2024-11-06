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
        Schema::create('visits', function (Blueprint $table) {
            $table->id();
            $table->string('country_id'); // علاقة مع جدول countries
            $table->string('country_name'); // علاقة مع جدول countries
            $table->string('city'); // اسم المدينة
            $table->string('region')->nullable();
            $table->string('session_id')->nullable();
            $table->unsignedBigInteger('scholarship_id')->nullable();
            $table->timestamps();

            // إعداد مفتاح أجنبي
            $table->foreign('session_id')->references('id')->on('sessions')->onDelete('cascade');
            $table->foreign('scholarship_id')->references('id')->on('scholarships')->onDelete('cascade');
            $table->foreign('country_id')->references('_id')->on('countries')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visits');
    }
};
