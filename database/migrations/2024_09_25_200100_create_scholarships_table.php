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
        Schema::create('scholarships', function (Blueprint $table) {
            $table->id();
            $table->string('title_ar');
            $table->string('title_en');
            $table->text('description_ar');
            $table->text('description_en');
            $table->enum('funding_type', ['full', 'partial', 'private']);
            $table->longText('content_ar');
            $table->longText('content_en');
            $table->string('slug_ar');
            $table->string('slug_en');
            $table->date('deadline');
            $table->string('image')->nullable();
            $table->foreignId('admin_id')->constrained('users')->onDelete('cascade');
            $table->string('visit')->nullable();
            $table->string('country_id')->nullable();
            $table->foreign('country_id')->references('_id')->on('countries')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('scholarships');
    }
};
