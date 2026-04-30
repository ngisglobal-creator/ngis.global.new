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
        Schema::table('user_news', function (Blueprint $table) {
            $table->string('video')->nullable()->after('images');
            // Adding 'promotion' to the enum
            $table->enum('type', ['news', 'advertisement', 'promotion'])->default('news')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_news', function (Blueprint $table) {
            $table->dropColumn('video');
            // Reverting the enum change is complex with change(), often simpler to just leave it or use DB::statement
            // For now, we'll just drop the column as type reversion can be destructive if 'promotion' data exists.
        });
    }
};
