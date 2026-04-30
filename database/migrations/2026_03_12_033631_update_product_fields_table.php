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
            // Drop old fields
            $table->dropColumn(['shipping_unit_type', 'quantity']);

            // Add new fields
            $table->decimal('piece_weight', 10, 2)->nullable()->comment('وزن الطرف او القطعة');
            $table->integer('product_piece_count')->nullable()->comment('عدد المنتج او الطرق');
            $table->decimal('carton_length', 10, 2)->nullable()->comment('طول الكرتونة (cm)');
            $table->decimal('carton_height', 10, 2)->nullable()->comment('ارتفاع الكرتونة (cm)');
            $table->decimal('carton_width', 10, 2)->nullable()->comment('عرض الكرتونة (cm)');
            $table->decimal('carton_volume_cbm', 10, 4)->nullable()->comment('حجم cbm الكرتونة');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('shipping_unit_type')->nullable();
            $table->integer('quantity')->default(0);

            $table->dropColumn([
                'piece_weight',
                'product_piece_count',
                'carton_length',
                'carton_height',
                'carton_width',
                'carton_volume_cbm'
            ]);
        });
    }
};
