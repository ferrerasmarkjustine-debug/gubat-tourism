<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Destination extends Model
{
    protected $fillable = [
        'municipality_id', 'name', 'description', 'category', 'image_url', 'rating', 'reviews_count', 'google_map_url', 'featured'
    ];

    public function municipality(): BelongsTo
    {
        return $this->belongsTo(Municipality::class);
    }

    public function barangay(): BelongsTo
    {
        return $this->belongsTo(Barangay::class);
    }

    public function getBarangayNameAttribute(): string
    {
        if (!empty($this->attributes['barangay_id']) && $this->barangay) {
            return $this->barangay->name;
        }

        $mapping = [
            'Lola Sayong Surf Camp' => 'Rizal',
            'Rizal Beach' => 'Rizal',
            'Barcelona Old Church' => 'Poblacion',
            'St. Anthony of Padua Parish' => 'Cota-na-daco',
            'Bulacao Abaca Weaving Association' => 'Bulacao',
            'Bentuco Clay Crafts' => 'Bentuco',
            'Gubat Heritage Ancestral Houses' => 'Poblacion',
        ];

        return $mapping[$this->name] ?? 'Rizal';
    }
}
