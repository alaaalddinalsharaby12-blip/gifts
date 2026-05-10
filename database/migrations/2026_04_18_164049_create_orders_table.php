<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            
            // تفاصيل المنتج وقت الطلب (للأرشفة)
            $table->string('product_name');
            
            // الخصائص المختارة (لون/حجم/ملاحظات)
            $table->json('attributes')->nullable();
            
            // الكمية
            $table->integer('quantity')->default(1);
            
            // حالة الطلب
            $table->string('status')->default('pending'); // pending, processing, completed, cancelled
            
            $table->json('data')->nullable(); // أو $table->text('data')->nullable();

            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};