<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // ✅ تحقق إذا العمود موجود قبل الإضافة
        if (!Schema::hasColumn('categories', 'video')) {
            Schema::table('categories', function (Blueprint $table) {
                $table->string('video')->nullable();
            });
        }
    }

    public function down(): void
    {
        // ✅ تحقق إذا العمود موجود قبل الحذف
        if (Schema::hasColumn('categories', 'video')) {
            Schema::table('categories', function (Blueprint $table) {
                $table->dropColumn('video');
            });
        }
    }
};