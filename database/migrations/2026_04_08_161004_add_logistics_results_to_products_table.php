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
            $table->decimal('total_weight', 10, 2)->nullable()->after('carton_volume_cbm')->comment('إجمالي وزن الكرتونة (كجم)');
            $table->decimal('total_cbm', 10, 4)->nullable()->after('total_weight')->comment('إجمالي حجم الكرتونة (CBM)');
            $table->integer('cbm_1_capacity')->nullable()->after('total_cbm')->comment('عدد الكراتين في 1 CBM');
            $table->integer('container_20ft_capacity')->nullable()->after('cbm_1_capacity')->comment('سعة الحاوية 20 قدم (كرتونة)');
            $table->integer('container_40ft_capacity')->nullable()->after('container_20ft_capacity')->comment('سعة الحاوية 40 قدم (كرتونة)');
            $table->integer('container_40hq_capacity')->nullable()->after('container_40ft_capacity')->comment('سعة الحاوية 40HQ (كرتونة)');
            $table->integer('container_45ft_capacity')->nullable()->after('container_40hq_capacity')->comment('سعة الحاوية 45 قدم (كرتونة)');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn([
                'total_weight',
                'total_cbm',
                'cbm_1_capacity',
                'container_20ft_capacity',
                'container_40ft_capacity',
                'container_40hq_capacity',
                'container_45ft_capacity'
            ]);
        });
    }
};
