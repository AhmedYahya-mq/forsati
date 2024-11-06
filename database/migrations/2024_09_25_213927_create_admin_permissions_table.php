<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('admin_permissions', function (Blueprint $table) {
            $table->id(); // معرف المستخدم
            $table->foreignId('admin_id')->constrained('users')->onDelete('cascade'); // علاقة مع جدول المستخدمين
            $table->string('permission_id'); // معرف الصلاحية كنص (string)
            // التأكد من أن العمود permission_id يشير إلى permissions.id
            $table->foreign('permission_id')->references('id')->on('permissions')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_permissions');
    }
};
