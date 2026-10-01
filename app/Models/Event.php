<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Event extends Model
{
    protected $fillable = [
        'municipality_id', 'title', 'description', 'event_date', 'location', 'image_url'
    ];

    protected $casts = [
        'event_date' => 'date',
    ];

    public function municipality(): BelongsTo
    {
        return $this->belongsTo(Municipality::class);
    }
}
