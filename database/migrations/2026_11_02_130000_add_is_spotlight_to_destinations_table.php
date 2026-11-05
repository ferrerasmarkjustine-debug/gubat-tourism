<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('destinations', function (Blueprint $table) {
            $table->boolean('is_spotlight')->default(false)->after('featured');
        });

        // Set default spotlights for Buenavista and Agoho if they exist
        DB::table('destinations')
            ->where('name', 'like', '%Buenavista%')
            ->orWhere('name', 'like', '%Agoho%')
            ->limit(2)
            ->update(['is_spotlight' => true]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('destinations', function (Blueprint $table) {
            $table->dropColumn('is_spotlight');
        });
    }
};
