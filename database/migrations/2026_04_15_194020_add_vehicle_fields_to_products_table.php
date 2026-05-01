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
            $table->string('vehicle_group')->nullable()->after('sku')->comment('light or heavy');
            $table->json('logistics_details')->nullable()->after('container_45ft_capacity')->comment('Full JSON with margins and specialized containers');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['vehicle_group', 'logistics_details']);
        });
    }
};
