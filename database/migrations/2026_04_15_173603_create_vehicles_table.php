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
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('sector_id')->constrained()->onDelete('cascade');
            $table->foreignId('branch_id')->constrained()->onDelete('cascade');
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            
            $table->string('name');
            $table->string('sku')->nullable();
            $table->decimal('price', 15, 2)->default(0);
            $table->string('currency_code', 10)->default('USD');
            $table->integer('min_order_quantity')->default(1);
            $table->longText('description')->nullable();
            
            // Dimensions & Weight
            $table->decimal('piece_weight', 12, 3)->default(0);
            $table->integer('product_piece_count')->default(0);
            $table->decimal('carton_length', 10, 3)->default(0);
            $table->decimal('carton_width', 10, 3)->default(0);
            $table->decimal('carton_height', 10, 3)->default(0);
            $table->decimal('unit_cbm', 15, 6)->default(0);
            $table->decimal('total_cbm', 15, 6)->default(0);
            $table->decimal('total_weight', 15, 3)->default(0);
            
            // Container Capacities (Main counts)
            $table->decimal('cap_20ft', 10, 2)->default(0);
            $table->decimal('cap_40ft', 10, 2)->default(0);
            $table->decimal('cap_40hq', 10, 2)->default(0);
            $table->decimal('cap_45ft', 10, 2)->default(0);
            
            // Specialized Containers (Calculated results stored)
            $table->decimal('spec_20ft_open_top', 10, 2)->default(0);
            $table->decimal('spec_40ft_open_top', 10, 2)->default(0);
            $table->decimal('spec_20ft_flat_rack', 10, 2)->default(0);
            $table->decimal('spec_40ft_flat_rack', 10, 2)->default(0);
            $table->decimal('spec_20ft_platform', 10, 2)->default(0);
            $table->decimal('spec_40ft_platform', 10, 2)->default(0);
            $table->decimal('spec_40ft_reefer', 10, 2)->default(0);
            $table->boolean('spec_roro')->default(false);
            
            // Technical details for internal capacity breakdown (Flat, Racking, etc.)
            // We store these as JSON for flexibility
            $table->json('logistics_details')->nullable(); 

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};
