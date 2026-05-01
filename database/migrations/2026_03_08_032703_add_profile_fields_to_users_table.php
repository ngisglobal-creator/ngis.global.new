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
        Schema::table('users', function (Blueprint $table) {
            $table->string('cover_image')->nullable()->after('avatar');
            $table->text('about_ar')->nullable()->after('cover_image');
            $table->text('about_en')->nullable()->after('about_ar');
            $table->integer('profile_products_count')->default(12)->after('about_en');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['cover_image', 'about_ar', 'about_en', 'profile_products_count']);
        });
    }
};
