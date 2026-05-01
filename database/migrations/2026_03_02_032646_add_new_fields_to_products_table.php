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
        Schema::table('products', function (Blueprint $table) {
            $table->integer('min_order_quantity')->default(1)->after('price');
            $table->string('shipping_unit_type')->nullable()->after('min_order_quantity');
            $table->json('custom_info')->nullable()->after('shipping_unit_type');
            $table->json('product_catalog')->nullable()->after('custom_info');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['min_order_quantity', 'shipping_unit_type', 'custom_info', 'product_catalog']);
        });
    }
};
