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
        Schema::create('crafts', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('category_slug')->default('abaca');
            $table->string('category_name')->default('Abaca Weaving');
            $table->text('description');
            $table->string('highlight')->nullable();
            $table->json('products')->nullable();
            $table->string('image_url')->nullable();
            $table->string('address')->nullable();
            $table->string('barangay')->nullable();
            $table->string('google_map_url')->nullable();
            $table->string('contact')->nullable();
            $table->string('badge_color')->default('#8D6E63');
            $table->boolean('is_featured')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('crafts');
    }
};
