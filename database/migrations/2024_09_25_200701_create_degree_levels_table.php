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
        Schema::create('degree_levels', function (Blueprint $table) {
            $table->id();
            $table->string('name_ar'); // اسم الدرجة الدراسية
            $table->string('name_en'); // اسم الدرجة الدراسية
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('degree_levels');
    }
};
