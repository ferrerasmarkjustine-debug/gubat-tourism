<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Resort extends Model
{
    protected $fillable = [
        'barangay_id', 'name', 'description', 'address', 'google_map_url',
        'rating', 'reviews_count', 'category', 'image_url', 'is_lgu_approved', 'featured'
    ];

    protected $casts = [
        'is_lgu_approved' => 'boolean',
        'featured' => 'boolean',
        'rating' => 'decimal:2',
    ];

    public function barangay(): BelongsTo
    {
        return $this->belongsTo(Barangay::class);
    }

    public function accommodations(): HasMany
    {
        return $this->hasMany(Accommodation::class);
    }

    public function bookings(): HasManyThrough
    {
        return $this->hasManyThrough(Booking::class, Accommodation::class);
    }

    public function admins(): HasMany
    {
        return $this->hasMany(User::class);
    }
}
