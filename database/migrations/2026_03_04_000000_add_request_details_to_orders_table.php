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
        Schema::table('orders', function (Blueprint $cell) {
            $cell->integer('quantity')->nullable()->after('product_id');
            $cell->string('shipping_unit_type')->nullable()->after('quantity');
            $cell->text('notes')->nullable()->after('shipping_unit_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $cell) {
            $cell->dropColumn(['quantity', 'shipping_unit_type', 'notes']);
        });
    }
};
