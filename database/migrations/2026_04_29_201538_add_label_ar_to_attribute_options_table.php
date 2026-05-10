<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('attribute_options', 'label_ar')) {
            Schema::table('attribute_options', function (Blueprint $table) {
                $table->string('label_ar')->nullable();
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('attribute_options', 'label_ar')) {
            Schema::table('attribute_options', function (Blueprint $table) {
                $table->dropColumn('label_ar');
            });
        }
    }
};