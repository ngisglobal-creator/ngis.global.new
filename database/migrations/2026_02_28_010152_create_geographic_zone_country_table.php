<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('geographic_zone_country', function (Blueprint $table) {
            $table->id();
            $table->foreignId('geographic_zone_id')->constrained('geographic_zones')->onDelete('cascade');
            $table->foreignId('country_id')->constrained('countries')->onDelete('cascade');
            $table->unique(['geographic_zone_id', 'country_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('geographic_zone_country');
    }
};
