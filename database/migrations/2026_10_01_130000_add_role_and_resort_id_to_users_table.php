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
            $table->string('role')->default('tourist')->after('email');
            $table->foreignId('resort_id')->nullable()->after('role')->constrained('resorts')->nullOnDelete();
            $table->boolean('is_active')->default(true)->after('resort_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['resort_id']);
            $table->dropColumn(['role', 'resort_id', 'is_active']);
        });
    }
};
