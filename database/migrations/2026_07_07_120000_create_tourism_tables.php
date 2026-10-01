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
        Schema::create('provinces', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('municipalities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('province_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('barangays', function (Blueprint $table) {
            $table->id();
            $table->foreignId('municipality_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('resorts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('barangay_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('address')->nullable();
            $table->string('google_map_url')->nullable();
            $table->decimal('rating', 3, 2)->default(5.0);
            $table->integer('reviews_count')->default(0);
            $table->string('category'); // luxury, eco, homestay, budget
            $table->string('image_url')->nullable();
            $table->boolean('is_lgu_approved')->default(true);
            $table->boolean('featured')->default(false);
            $table->timestamps();
        });

        Schema::create('amenities', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('icon_class');
            $table->timestamps();
        });

        Schema::create('accommodations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('resort_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('type'); // room, cottage, villa, dorm
            $table->decimal('price_per_night', 10, 2);
            $table->integer('max_guests');
            $table->integer('total_units')->default(1);
            $table->text('description')->nullable();
            $table->string('image_url')->nullable();
            $table->timestamps();
        });

        Schema::create('accommodation_amenity', function (Blueprint $table) {
            $table->foreignId('accommodation_id')->constrained()->cascadeOnDelete();
            $table->foreignId('amenity_id')->constrained()->cascadeOnDelete();
            $table->primary(['accommodation_id', 'amenity_id']);
        });

        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('accommodation_id')->constrained()->cascadeOnDelete();
            $table->date('check_in');
            $table->date('check_out');
            $table->integer('rooms_booked')->default(1);
            $table->integer('guests_count')->default(1);
            $table->string('status')->default('confirmed');
            $table->timestamps();
        });

        Schema::create('destinations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('municipality_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('category'); // Surf Haven, Public Beach, Heritage Landmark, Century-Old Church
            $table->string('image_url')->nullable();
            $table->decimal('rating', 3, 2)->default(5.0);
            $table->integer('reviews_count')->default(0);
            $table->string('google_map_url')->nullable();
            $table->boolean('featured')->default(false);
            $table->timestamps();
        });

        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('municipality_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->text('description')->nullable();
            $table->date('event_date');
            $table->string('location')->nullable();
            $table->string('image_url')->nullable();
            $table->timestamps();
        });

        Schema::create('announcements', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('content')->nullable();
            $table->string('category')->default('General');
            $table->string('image_url')->nullable();
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
        });

        Schema::create('testimonials', function (Blueprint $table) {
            $table->id();
            $table->string('visitor_name');
            $table->string('visitor_role')->nullable();
            $table->text('content');
            $table->integer('rating')->default(5);
            $table->string('image_url')->nullable();
            $table->timestamps();
        });

        Schema::create('weather_tips', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('content');
            $table->string('icon_class')->default('bi-sun');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('weather_tips');
        Schema::dropIfExists('testimonials');
        Schema::dropIfExists('announcements');
        Schema::dropIfExists('events');
        Schema::dropIfExists('destinations');
        Schema::dropIfExists('bookings');
        Schema::dropIfExists('accommodation_amenity');
        Schema::dropIfExists('accommodations');
        Schema::dropIfExists('amenities');
        Schema::dropIfExists('resorts');
        Schema::dropIfExists('barangays');
        Schema::dropIfExists('municipalities');
        Schema::dropIfExists('provinces');
    }
};
