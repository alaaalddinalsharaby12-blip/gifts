<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // ✅ إضافة status بدون after (أو بعد عمود موجود)
            if (!Schema::hasColumn('orders', 'status')) {
                $table->string('status')->default('pending');
            }
            
            // ✅ إضافة attributes إذا لم يكن موجوداً
            if (!Schema::hasColumn('orders', 'attributes')) {
                $table->json('attributes')->nullable();
            }
            
            // ✅ إضافة باقي الأعمدة
            if (!Schema::hasColumn('orders', 'quantity')) {
                $table->integer('quantity')->default(1);
            }
            
            if (!Schema::hasColumn('orders', 'product_name')) {
                $table->string('product_name')->nullable();
            }
            
            if (!Schema::hasColumn('orders', 'notes')) {
                $table->text('notes')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $columns = ['status', 'attributes', 'quantity', 'product_name', 'notes'];
            
            foreach ($columns as $column) {
                if (Schema::hasColumn('orders', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};