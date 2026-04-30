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
        Schema::table('orders', function (Blueprint $table) {
            $table->integer('cartons_count')->nullable()->after('quantity');
            $table->decimal('total_weight', 12, 2)->nullable()->after('cartons_count');
            $table->decimal('total_cbm', 12, 3)->nullable()->after('total_weight');
            $table->decimal('total_cost', 15, 2)->nullable()->after('total_cbm');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['cartons_count', 'total_weight', 'total_cbm', 'total_cost']);
        });
    }
};
