<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Amenity extends Model
{
    protected $fillable = ['name', 'icon_class'];

    public function accommodations(): BelongsToMany
    {
        return $this->belongsToMany(Accommodation::class, 'accommodation_amenity');
    }
}
