<?php
// database/migrations/xxxx_remove_price_from_orders_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['product_price', 'total']);
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->decimal('product_price', 10, 2)->nullable();
            $table->decimal('total', 10, 2)->nullable();
        });
    }
};