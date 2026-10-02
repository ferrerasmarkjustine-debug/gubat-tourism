<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Accommodation extends Model
{
    protected $fillable = [
        'resort_id', 'name', 'type', 'price_per_night', 'max_guests',
        'total_units', 'description', 'image_url', 'status', 'rejection_reason'
    ];

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function isApproved(): bool
    {
        return $this->status === 'approved';
    }

    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    /**
     * Get currently active booked units count for today or a specific date range.
     */
    public function getBookedUnitsCount($checkIn = null, $checkOut = null): int
    {
        $today = now()->toDateString();
        $start = $checkIn ? \Carbon\Carbon::parse($checkIn)->toDateString() : $today;
        $end   = $checkOut ? \Carbon\Carbon::parse($checkOut)->toDateString() : now()->addDay()->toDateString();

        return (int) $this->bookings()
            ->where('status', 'confirmed')
            ->where('check_in', '<', $end)
            ->where('check_out', '>', $start)
            ->sum('rooms_booked');
    }

    /**
     * Get remaining available units today.
     */
    public function getAvailableUnitsAttribute(): int
    {
        $booked = $this->getBookedUnitsCount();
        return max(0, $this->total_units - $booked);
    }

    /**
     * Get total active booked units today.
     */
    public function getBookedUnitsAttribute(): int
    {
        return $this->getBookedUnitsCount();
    }

    public function resort(): BelongsTo
    {
        return $this->belongsTo(Resort::class);
    }

    public function amenities(): BelongsToMany
    {
        return $this->belongsToMany(Amenity::class, 'accommodation_amenity');
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }
}
